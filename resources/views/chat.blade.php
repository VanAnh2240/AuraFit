<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>ChatBot Demo</title>
    <link rel="stylesheet" href="{{asset('frontend/css/chat.css')}}">
</head>
<body>
    <h1>AuraFit AI Stylist</h1>

    <div class="quick-inputs">
        <h2>TÙY CHỌN NHANH</h2>

        <label for="height">Chiều cao: <span id="heightValue">160</span> cm</label>
        <input type="range" id="height" min="140" max="200" value="160">

        <label for="weight">Cân nặng: <span id="weightValue">50</span> kg</label>
        <input type="range" id="weight" min="40" max="100" value="50">

        <label for="age">Tuổi: <span id="ageValue">25</span></label>
        <input type="range" id="age" min="16" max="70" value="25">

        <div class="purpose-list">
            <label><input type="radio" name="purpose" value="Đi làm"><span>Đi làm</span></label>
            <label><input type="radio" name="purpose" value="Đi chơi, dạo phố"><span>Đi chơi, dạo phố</span></label>
            <label><input type="radio" name="purpose" value="Đi đám cưới"><span>Đi đám cưới</span></label>
            <label><input type="radio" name="purpose" value="Dự tiệc"><span>Dự tiệc </span></label>
            <!-- <label><input type="radio" name="purpose" value="Hẹn hò"><span>Hẹn hò</span></label>
            <label><input type="radio" name="purpose" value="Dịp quan trọng (Lễ tốt nghiệp, Lễ hội, Tết,..)"><span>Dịp quan trọng (Lễ tốt nghiệp, Lễ hội, Tết,..)</span></label> -->
        </div>

        <button id="confirmBtn">Nhập nhanh</button>
    </div>
    
    <div class="chat-box">
        @foreach ($messages as $msg)
            <div class="message {{ $msg->role }}">
                @if ($msg->role === 'assistant')
                    <div class="assistant-content" data-raw="{{ $msg->content }}"></div>
                @else
                    <strong>{{ ucfirst($msg->role) }}:</strong> {{ $msg->content }}
                @endif
            </div>
        @endforeach
    </div>

    <form id="chatForm" action="{{ url('/chat/' . ($threadId ?? '')) }}" method="POST">
        @csrf
        <input id="chatInput" type="text" name="message" placeholder="Nhập tin nhắn..." required style="width: 80%">
        <button type="submit">Gửi</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
   
    <script>
        document.querySelectorAll('.assistant-content').forEach(el => {
            let raw = el.getAttribute('data-raw');
            el.innerHTML = marked.parse(raw);
        });

        document.getElementById("height").oninput = function() {
            document.getElementById("heightValue").innerText = this.value;
        };
        document.getElementById("weight").oninput = function() {
            document.getElementById("weightValue").innerText = this.value;
        };
        document.getElementById("age").oninput = function() {
            document.getElementById("ageValue").innerText = this.value;
        };

        document.getElementById("confirmBtn").addEventListener("click", function() {
            const height = document.getElementById("height").value;
            const weight = document.getElementById("weight").value;
            const age = document.getElementById("age").value;
            const purpose = document.querySelector('input[name="purpose"]:checked');

            if (!purpose) {
                alert("Vui lòng chọn mục đích!");
                return;
            }

            let input = document.getElementById("chatInput");
            input.value = `Chiều cao: ${height}cm, Cân nặng: ${weight}kg, Tuổi: ${age}, Mục đích: ${purpose.value}`;
            document.getElementById("chatForm").submit();
        });
    </script>
</body>
</html>
