<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Conversation;
use App\Models\Mensahe;
use Illuminate\Support\Facades\Auth;

use Livewire\WithFileUploads;

class ChatBox extends Component
{
    use WithFileUploads;

    public $conversationId;
    public $conversation;
    public $messages = [];
    public $messageText; 
    public $file; // new property for uploaded file

    public function mount()
    {
        $this->loadConversation();
    }

    public function updatedConversationId()
    {
        $this->loadConversation();
    }

    public function loadConversation()
    {
        if (!$this->conversationId) {
            $this->messages = [];
            $this->conversation = null;
            return;
        }

        $this->conversation = Conversation::with(['userOne', 'userTwo', 'messages.sender.profile'])
            ->find($this->conversationId);

        if (!$this->conversation) {
            $this->messages = [];
            return;
        }

        // ✅ MARK MESSAGES AS READ
        Mensahe::where('conversation_id', $this->conversationId)
            ->where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $this->messages = $this->conversation->messages
            ->where('is_deleted', false)
            ->sortBy('created_at')
            ->values();
    }


    public function sendMessage()
    {
        // ✅ NO VALIDATION = NO ERRORS
        if (!$this->conversationId) return;

        // Must have file OR message
        if (!$this->file && !$this->messageText) return;

        $data = [
            'conversation_id' => $this->conversationId,
            'sender_id' => auth()->id(),
            'receiver_id' => $this->conversation->user_one == auth()->id() 
                ? $this->conversation->user_two 
                : $this->conversation->user_one,
            'is_read' => false, 
        ];

        if ($this->file) {
            $path = $this->file->store('chat_files', 'public');
            $data['file_path'] = $path;
            $data['file_name'] = $this->file->getClientOriginalName();
            $data['file_type'] = $this->file->getClientOriginalExtension();
            $this->file = null;
        } else {
            $data['message'] = $this->messageText;
            $this->messageText = '';
        }

        Mensahe::create($data);
        $this->loadConversation();
    }

    //  MARK AS READ WHEN VIEWED
    public function markAsRead()
    {
        if (!$this->conversationId) return;

        Mensahe::where('conversation_id', $this->conversationId)
            ->where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        $this->loadConversation();
    }

    //chat settings 
    public function archiveConversation()
    {
        if (!$this->conversation) return;

        $authId = auth()->id();

        if ($authId == $this->conversation->user_one) {
            $this->conversation->update(['archived_by_user_one' => true]);
        } else {
            $this->conversation->update(['archived_by_user_two' => true]);
        }

        $this->loadConversation(); // reload to refresh state
    }

    public function unarchiveConversation()
    {
        if (!$this->conversation) return;

        $authId = auth()->id();

        if ($authId == $this->conversation->user_one) {
            $this->conversation->update(['archived_by_user_one' => false]);
        } else {
            $this->conversation->update(['archived_by_user_two' => false]);
        }

        $this->loadConversation(); // reload to refresh state
    }

    public function deleteConversation()
    {
        if (!$this->conversation) return;

        $authId = auth()->id();

        if ($authId == $this->conversation->user_one) {
            $this->conversation->update(['deleted_by_user_one' => true]);
        } else {
            $this->conversation->update(['deleted_by_user_two' => true]);
        }

        // Reset component state
        $this->conversation = null;
        $this->messages = [];
        $this->conversationId = null;
    }

    public function deleteConversationConfirmed()
    {
        $this->deleteConversation();

        // Redirect to chat list route
        return redirect()->route('chat-list'); // <-- replace 'chat.list' with your route name
    }

    public function render()
    {
        return view('livewire.chat-box');
    }
}
