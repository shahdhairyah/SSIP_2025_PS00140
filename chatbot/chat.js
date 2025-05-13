class Chat {
    constructor() {
        this.messageInput = document.getElementById('message-input');
        this.fileInput = document.getElementById('file-input');
        this.sendButton = document.getElementById('send-button');
        this.chatMessages = document.getElementById('chat-messages');
        this.usersContainer = document.getElementById('users-container');
        this.recipientSelect = document.getElementById('recipient-select');
        this.departmentSelect = document.getElementById('department-select');
        this.viewTypeSelect = document.getElementById('view-type-select');
        this.replyingTo = null;
        this.isLoading = false;
        
        this.setupEventListeners();
        this.initializeSendButton();
        this.loadUsers();
        this.loadMessages();
        
        // Refresh messages every 5 seconds
        setInterval(() => this.loadMessages(), 5000);
        // Check for new notifications every 10 seconds
        setInterval(() => this.checkNewNotifications(), 10000);
    }

    initializeSendButton() {
        // Update send button HTML to include loader
        this.sendButton.innerHTML = `
            <span class="send-button-content">Send</span>
            <span class="loader"></span>
        `;
    }

    setupEventListeners() {
        this.sendButton.addEventListener('click', () => this.handleSend());
        this.messageInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') this.handleSend();
        });
        this.fileInput.addEventListener('change', (e) => this.handleFileSelect(e));
        
        if (this.departmentSelect) {
            this.departmentSelect.addEventListener('change', () => this.loadUsers());
        }

        if (this.viewTypeSelect) {
            this.viewTypeSelect.addEventListener('change', () => this.loadUsers());
        }
    }

    setLoading(loading) {
        this.isLoading = loading;
        this.sendButton.disabled = loading;
        this.sendButton.classList.toggle('loading', loading);
        this.messageInput.disabled = loading;
        this.fileInput.disabled = loading;
        if (this.recipientSelect) {
            this.recipientSelect.disabled = loading;
        }
    }

    async loadUsers() {
        try {
            const department = this.departmentSelect ? this.departmentSelect.value : '';
            const viewType = this.viewTypeSelect ? this.viewTypeSelect.value : 'all';
            const response = await fetch(`server/get_users.php?department=${department}&view_type=${viewType}`);
            const data = await response.json();
            
            if (data.status === 'success') {
                // Update users list
                this.usersContainer.innerHTML = data.users.map(user => `
                    <div class="user-item" data-id="${user.id}" data-department="${user.department}">
                        <span class="user-name">${user.fullname}</span>
                        <span class="user-type">${user.user_type}</span>
                        <span class="user-department">${user.department || 'All Departments'}</span>
                    </div>
                `).join('');

                // Update recipients dropdown
                if (userType === 'employee') {
                    const recipients = data.users.map(user => ({
                        id: user.id,
                        fullname: user.fullname,
                        user_type: user.user_type,
                        department: user.department
                    }));
                    this.updateRecipientSelect(recipients);
                } else if (userType === 'super_admin') {
                    // Super admin can send to any department admin
                    const departmentAdmins = data.users.filter(user => 
                        user.user_type === 'department_admin'
                    );
                    this.updateRecipientSelect(departmentAdmins);
                } else if (userType === 'department_admin') {
                    // Department admin can send to their department users and super admin
                    const filteredUsers = data.users.filter(user => 
                        (user.department === userDepartment && user.user_type === 'employee') || 
                        user.user_type === 'super_admin'
                    );
                    // Add "All Department Members" option for department admin
                    filteredUsers.unshift({
                        id: 'all_department',
                        fullname: 'All Department Members',
                        user_type: 'group',
                        department: userDepartment
                    });
                    this.updateRecipientSelect(filteredUsers);
                }
            }
        } catch (error) {
            console.error('Failed to load users:', error);
        }
    }

    updateRecipientSelect(users) {
        this.recipientSelect.innerHTML = users.map(user => `
            <option value="${user.id}">
                ${user.fullname} ${user.user_type === 'group' ? '' : `(${user.user_type}${user.department ? ' - ' + user.department : ''})`}
            </option>
        `).join('');
    }

    async loadMessages() {
        if (this.isLoading) return;
        
        try {
            const response = await fetch('server/get_messages.php');
            const data = await response.json();
            
            if (data.status === 'success') {
                this.chatMessages.innerHTML = '';
                data.messages.forEach(msg => {
                    this.addMessage(msg);
                });
                this.scrollToBottom();
            }
        } catch (error) {
            console.error('Failed to load messages:', error);
        }
    }

    async handleSend() {
        const message = this.messageInput.value.trim();
        const files = this.fileInput.files;
        const recipients = Array.from(this.recipientSelect.selectedOptions).map(option => option.value);

        if ((!message && files.length === 0) || recipients.length === 0) return;
        
        this.setLoading(true);

        const formData = new FormData();
        formData.append('message', message);
        formData.append('recipients', JSON.stringify(recipients));

        if (files.length > 0) {
            for (let i = 0; i < files.length; i++) {
                formData.append('files[]', files[i]);
            }
        }

        if (this.replyingTo) {
            formData.append('reply_to', this.replyingTo.id);
        }

        try {
            const response = await fetch('server/send_message.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();
            
            if (data.status === 'success') {
                this.messageInput.value = '';
                this.fileInput.value = '';
                this.clearReply();
                await this.loadMessages();
            }
        } catch (error) {
            console.error('Failed to send message:', error);
        } finally {
            this.setLoading(false);
        }
    }

    handleFileSelect(event) {
        const files = event.target.files;
        if (files.length > 0) {
            const fileNames = Array.from(files).map(file => file.name).join(', ');
            this.messageInput.value += `[Attached: ${fileNames}]`;
        }
    }

    setReplyTo(message) {
        this.replyingTo = message;
        const replyPreview = document.createElement('div');
        replyPreview.className = 'reply-preview';
        replyPreview.innerHTML = `
            <div class="reply-content">
                <span class="reply-to">Replying to ${message.sender_name}</span>
                <p class="reply-text">${message.message}</p>
            </div>
            <button class="clear-reply" onclick="chat.clearReply()">×</button>
        `;
        
        const inputContainer = document.querySelector('.chat-input-container');
        const existingPreview = inputContainer.querySelector('.reply-preview');
        if (existingPreview) {
            existingPreview.remove();
        }
        inputContainer.insertBefore(replyPreview, inputContainer.firstChild);
        this.messageInput.focus();
    }

    clearReply() {
        this.replyingTo = null;
        const replyPreview = document.querySelector('.reply-preview');
        if (replyPreview) {
            replyPreview.remove();
        }
    }

    addMessage(message) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${message.sender_id === currentUserId ? 'user' : 'other'}`;
        
        const header = document.createElement('div');
        header.className = 'message-header';
        header.innerHTML = `
            <span class="sender-name">${message.sender_name}</span>
            <span class="message-time">${new Date(message.created_at).toLocaleString()}</span>
        `;
        messageDiv.appendChild(header);

        if (message.reply_to) {
            const replyDiv = document.createElement('div');
            replyDiv.className = 'replied-message';
            replyDiv.innerHTML = `
                <div class="reply-indicator">
                    <span class="reply-sender">${message.reply_to.sender_name}</span>
                    <p class="reply-content">${message.reply_to.message}</p>
                </div>
            `;
            messageDiv.appendChild(replyDiv);
        }

        if (message.message) {
            const textDiv = document.createElement('div');
            textDiv.className = 'message-text';
            textDiv.textContent = message.message;
            messageDiv.appendChild(textDiv);
        }

        if (message.files && message.files.length > 0) {
            message.files.forEach(file => {
                const attachment = this.createAttachmentPreview(file);
                messageDiv.appendChild(attachment);
            });
        }

        const actions = document.createElement('div');
        actions.className = 'message-actions';
        actions.innerHTML = `
            <button onclick='chat.setReplyTo(${JSON.stringify(message)})' class="reply-button">
                ↩ Reply
            </button>
        `;
        messageDiv.appendChild(actions);

        this.chatMessages.appendChild(messageDiv);
    }

    createAttachmentPreview(file) {
        const container = document.createElement('div');
        container.className = 'attachment';

        if (file.type.startsWith('image/')) {
            const img = document.createElement('img');
            img.src = file.path;
            img.className = 'message-attachment';
            container.appendChild(img);
        } else {
            const fileLink = document.createElement('a');
            fileLink.href = file.path;
            fileLink.className = 'file-attachment';
            fileLink.innerHTML = `
                <span class="file-icon">📄</span>
                <span class="file-name">${file.name}</span>
            `;
            container.appendChild(fileLink);
        }

        return container;
    }

    async checkNewNotifications() {
        try {
            const response = await fetch('server/get_notifications.php');
            const data = await response.json();
            
            if (data.status === 'success' && data.notifications.length > 0) {
                this.showNotificationPopup(data.notifications);
            }
        } catch (error) {
            console.error('Failed to fetch notifications:', error);
        }
    }
    
    showNotificationPopup(notifications) {
        const existingPopup = document.getElementById('notificationPopup');
        if (existingPopup) {
            existingPopup.remove();
        }

        const popup = document.createElement('div');
        popup.id = 'notificationPopup';
        popup.className = 'notification-popup';
        
        popup.innerHTML = `
            <div class="notification-content">
                <h4>New Messages</h4>
                <ul>
                    ${notifications.map(notif => `
                        <li>
                            <strong>${notif.sender_name}</strong>: 
                            ${notif.message.length > 50 ? notif.message.substring(0, 50) + '...' : notif.message}
                        </li>
                    `).join('')}
                </ul>
                <button onclick="chat.dismissNotifications()" class="dismiss-btn">Dismiss</button>
            </div>
        `;
        
        document.body.appendChild(popup);
        
        // Auto-dismiss after 5 seconds
        setTimeout(() => this.dismissNotifications(), 5000);
    }
    
    dismissNotifications() {
        const popup = document.getElementById('notificationPopup');
        if (popup) {
            popup.remove();
        }
    }

    scrollToBottom() {
        this.chatMessages.scrollTop = this.chatMessages.scrollHeight;
    }
}

// Initialize chat
const chat = new Chat();