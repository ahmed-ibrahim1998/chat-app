<?php $__env->startSection('content'); ?>
    <div class="container mt-5">
        <h1 class="mb-4">Chat</h1>
        <div class="row">
            <!-- Users List -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Users</div>
                    <ul class="list-group list-group-flush" id="users-list">
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center"
                                data-user-id="<?php echo e($user->id); ?>">
                                <?php echo e($user->name); ?>

                                <span class="badge bg-secondary" id="status-<?php echo e($user->id); ?>">Offline</span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
            <!-- Chat Area -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Chat with <span id="chat-with">Select a user</span></div>
                    <div class="card-body" style="height: 400px; overflow-y: auto;" id="messages"></div>
                    <div class="card-footer">
                        <div class="input-group">
                            <input type="text" id="message" class="form-control" placeholder="Type your message">
                            <input type="hidden" id="receiver_id">
                            <button class="btn btn-primary" onclick="sendMessage()">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>

        let pollingInterval = null; // Variable to store the interval

        const pusher = new Pusher('<?php echo e(env('REVERB_APP_KEY')); ?>', {
            wsHost: '<?php echo e(env('REVERB_HOST')); ?>',
            wsPort: <?php echo e(env('REVERB_PORT')); ?>,
            forceTLS: false,
            cluster: 'mt1',
            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                }
            }
        });

        // Subscribe to private channel for messages
        const channel = pusher.subscribe('private-chat.' + <?php echo e(auth()->id()); ?>);
        channel.bind('App\\Events\\MessageSent', function (data) {
            if (data.message.sender_id == document.getElementById('receiver_id').value || data.message.receiver_id == <?php echo e(auth()->id()); ?>) {
                appendMessage(data.message.message, data.message.sender_id == <?php echo e(auth()->id()); ?> ? 'me' : 'them');
            }
        });

        // Subscribe to presence channel for online/offline status
        const presenceChannel = pusher.subscribe('presence-online');
        presenceChannel.bind('pusher:subscription_succeeded', function (members) {
            members.each(function (member) {
                updateStatus(member.id, 'Online');
            });
        });
        presenceChannel.bind('pusher:member_added', function (member) {
            updateStatus(member.id, 'Online');
        });
        presenceChannel.bind('pusher:member_removed', function (member) {
            updateStatus(member.id, 'Offline');
        });

        // Send message
        function sendMessage() {
            const message = document.getElementById('message').value;
            const receiverId = document.getElementById('receiver_id').value;
            if (!receiverId) {
                alert('Please select a user to chat with!');
                return;
            }
            fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({message, receiver_id: receiverId})
            }).then(() => {
                appendMessage(message, 'me');
                document.getElementById('message').value = '';
            });
        }

        // Append message to chat
        function appendMessage(message, sender) {
            const messagesDiv = document.getElementById('messages');
            const messageDiv = document.createElement('div');
            messageDiv.className = sender === 'me' ? 'text-end mb-2' : 'text-start mb-2';
            messageDiv.innerHTML = `<span class="badge ${sender === 'me' ? 'bg-primary' : 'bg-secondary'}">${message}</span>`;
            messagesDiv.appendChild(messageDiv);
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }

        // Update online/offline status
        function updateStatus(userId, status) {
            const statusBadge = document.getElementById('status-' + userId);
            if (statusBadge) {
                statusBadge.textContent = status;
                statusBadge.className = 'badge ' + (status === 'Online' ? 'bg-success' : 'bg-secondary');
            }
        }

        // Load messages when selecting a user
        document.querySelectorAll('#users-list li').forEach(user => {
            user.addEventListener('click', function () {
                const receiverId = this.getAttribute('data-user-id');
                document.getElementById('receiver_id').value = receiverId;
                document.getElementById('chat-with').textContent = this.textContent.trim().split(' ')[0];
                document.getElementById('messages').innerHTML = '';
                fetch('/chat/messages/' + receiverId)
                    .then(response => response.json())
                    .then(messages => {
                        messages.forEach(msg => {
                            appendMessage(msg.message, msg.sender_id == <?php echo e(auth()->id()); ?> ? 'me' : 'them');
                        });
                    });
            });
        });

        // Load messages with polling
        function loadMessages(receiverId, name) {
            if (pollingInterval) {
                clearInterval(pollingInterval); // Stop previous polling
            }

            document.getElementById('receiver_id').value = receiverId;
            document.getElementById('chat-with').textContent = name;
            document.getElementById('messages').innerHTML = '';

            function fetchMessages() {
                fetch('/chat/messages/' + receiverId)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to load messages');
                        }
                        return response.json();
                    })
                    .then(messages => {
                        const messagesDiv = document.getElementById('messages');
                        messagesDiv.innerHTML = ''; // Clear old messages
                        messages.forEach(msg => {
                            appendMessage(msg.message, msg.sender_id == <?php echo e(auth()->id()); ?> ? 'me' : 'them');
                        });
                    })
                    .catch(error => console.error('Load messages error:', error));
            }

            fetchMessages(); // Fetch immediately
            pollingInterval = setInterval(fetchMessages, 2000); // Poll every 2 seconds
        }

        // Load messages when selecting a user
        document.querySelectorAll('#users-list li').forEach(user => {
            user.addEventListener('click', function () {
                const receiverId = this.getAttribute('data-user-id');
                const name = this.textContent.trim().split(' ')[0];
                loadMessages(receiverId, name);
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app2', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\مشروع دردشه\chat-app\resources\views/chat/chat.blade.php ENDPATH**/ ?>