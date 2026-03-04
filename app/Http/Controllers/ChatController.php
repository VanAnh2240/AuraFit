<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use OpenAI\Laravel\Facades\OpenAI;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat', [
            'messages' => collect([]),
            'threadId' => null
        ]);
    }

    public function start($threadId = null)
    {
        $thread = null;

        if ($threadId) {
            $thread = Thread::with('messages')->find($threadId);
        }

        return view('chat', [
            'threadId' => $thread?->id,
            'messages' => $thread?->messages ?? collect()
        ]);
    }

    public function ask(Request $request, $threadId = null)
    {
        $userMessage = $request->input('message');

        // Nếu chưa có thread_id thì tạo mới
        if (!$threadId) {
            $thread = Thread::create([
                'title' => 'New Conversation',
                'openai_thread_id' => null,
            ]);

            // Tạo thread trên OpenAI — SDK yêu cầu một mảng (có thể rỗng)
            $apiThread = OpenAI::threads()->create([]); // <-- quan trọng: truyền array

            // Debug nhanh nếu apiThread không trả id (nếu vẫn null thì dd để kiểm tra)
            if (empty($apiThread->id)) {
                dd($apiThread); // bỏ dòng này sau khi debug
            }

            // Lưu openai_thread_id ngay lập tức và gán lại object để dùng tiếp
            $thread->openai_thread_id = $apiThread->id;
            $thread->save();
        } else {
            $thread = Thread::findOrFail($threadId);
        }

        // Gửi message của user vào thread (dùng giá trị đã lưu)
        OpenAI::threads()->messages()->create($thread->openai_thread_id, [
            'role' => 'user',
            'content' => $userMessage,
        ]);

        // Chạy assistant với thread vừa tạo
        $run = OpenAI::threads()->runs()->create(
            $thread->openai_thread_id,
            [
                'assistant_id' => env('OPENAI_ASSISTANT_ID'),
            ]
        );

        // Polling kết quả (giới hạn 15 lần)
        $maxTries = 15;
        $tries = 0;
        do {
            sleep(1);
            $runStatus = OpenAI::threads()->runs()->retrieve(
                $thread->openai_thread_id,
                $run->id
            );
            $tries++;
        } while ($runStatus->status !== 'completed' && $tries < $maxTries);

        // Lấy tất cả messages trong thread từ OpenAI
        $messages = OpenAI::threads()->messages()->list($thread->openai_thread_id);

        // Lấy tin nhắn assistant mới nhất (an toàn)
        $assistantMessage = collect($messages->data)
            ->where('role', 'assistant')
            ->first();

        $assistantReply = $assistantMessage?->content[0]->text->value ?? 'Không có phản hồi';

        // Trả về view giống cấu trúc cũ (bạn đang dùng threadModel->messages; nếu muốn hiển thị history từ OpenAI, bạn cần map $messages sang dạng model/object)
        return view('chat', [
            'threadId' => $thread->id,
            // Nếu bạn muốn dùng dữ liệu trả từ OpenAI (để Blade foreach hoạt động), map như sau:
            'messages' => collect($messages->data)->map(function ($m) {
                return (object)[
                    'role' => $m->role,
                    'content' => $m->content[0]->text->value ?? '',
                ];
            })->reverse()->values(),
        ]);
    }

    
}
