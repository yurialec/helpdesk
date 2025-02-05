<!-- resources/views/chat/widget.blade.php -->
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Widget</title>
    <style>
        /* Defina o estilo para o widget aqui */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .chat-container {
            position: fixed;
            bottom: 10px;
            right: 10px;
            width: 300px;
            height: 400px;
            border: 1px solid #ccc;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .chat-header {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .chat-messages {
            height: 280px;
            overflow-y: auto;
            padding: 10px;
        }

        .chat-input {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            display: flex;
            background-color: #f1f1f1;
            padding: 10px;
        }

        .chat-input textarea {
            width: 80%;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .chat-input button {
            width: 15%;
            margin-left: 5px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .chat-input button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="chat-container">
        <div class="chat-header">
            Chat Support
        </div>
        <div class="chat-messages">
            <!-- As mensagens do chat serão adicionadas aqui via JavaScript -->
        </div>
        <div class="chat-input">
            <textarea placeholder="Digite sua mensagem..." rows="1"></textarea>
            <button>Enviar</button>
        </div>
    </div>

    <script>
        // Código JS simples para capturar e enviar a mensagem
        const button = document.querySelector(".chat-input button");
        const textarea = document.querySelector(".chat-input textarea");
        const chatMessages = document.querySelector(".chat-messages");

        button.addEventListener('click', function () {
            const message = textarea.value;
            if (message) {
                const messageDiv = document.createElement('div');
                messageDiv.textContent = message;
                chatMessages.appendChild(messageDiv);
                textarea.value = ''; // Limpa o campo de entrada
                chatMessages.scrollTop = chatMessages.scrollHeight; // Rolagem para a última mensagem
            }
        });
    </script>
</body>

</html>