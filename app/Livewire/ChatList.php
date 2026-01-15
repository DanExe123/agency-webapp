<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Conversation;
use App\Models\Mensahe;

class ChatList extends Component
{
    public $conversationId;

    public function mount()
    {
        // Open chat if user parameter is passed in URL
        if (request()->has('user')) {
            $this->startConversation(request('user'));
        }
    }

    public function startConversation($userId)
    {
        $authId = auth()->id();

        if ($authId == $userId) return;

        $conversation = Conversation::where(function ($q) use ($authId, $userId) {
                $q->where('user_one', $authId)
                  ->where('user_two', $userId);
            })
            ->orWhere(function ($q) use ($authId, $userId) {
                $q->where('user_one', $userId)
                  ->where('user_two', $authId);
            })
            ->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'user_one' => $authId,
                'user_two' => $userId,
            ]);
        }

        $this->conversationId = $conversation->id;
    }

    public function openChat($id)
    {
        $this->conversationId = $id;

        // Mark messages as read for this conversation
        Mensahe::where('conversation_id', $id)
            ->where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
            ]);
    }


    public function archiveConversation($id)
    {
        $authId = auth()->id();
        $conversation = Conversation::find($id);
        if (!$conversation) return;

        if ($authId == $conversation->user_one) {
            $conversation->update(['archived_by_user_one' => true]);
        } else {
            $conversation->update(['archived_by_user_two' => true]);
        }
    }

    public function openArchivedChat($chatId)
    {
        $chat = Conversation::find($chatId);
        if (!$chat) return;

        $authId = auth()->id();

        // Unarchive if archived by the current user
        if ($authId == $chat->user_one && $chat->archived_by_user_one) {
            $chat->update(['archived_by_user_one' => false]);
        } elseif ($authId == $chat->user_two && $chat->archived_by_user_two) {
            $chat->update(['archived_by_user_two' => false]);
        }

        $this->conversationId = $chat->id;
    }


    public function render()
    {
        /*  $conversations = Conversation::where('user_one', auth()->id())
            ->orWhere('user_two', auth()->id())
            ->with([
                'lastMessage.sender.profile',
                'userOne.profile',
                'userTwo.profile',
                'messages' => function($query) {
                    $query->where('receiver_id', auth()->id())
                        ->where('is_read', false)
                        ->where('is_deleted', false);
                }
            ])
            ->withMax('messages', 'created_at') // 👈 newest activity
            ->orderByDesc('messages_max_created_at') // 👈 newest on top
            ->get();*/
            
        $authId = auth()->id();

        $activeConversations = Conversation::where(function($q) use ($authId) {
                $q->where('user_one', $authId)->where('archived_by_user_one', false)->where('deleted_by_user_one', false)
                  ->orWhere(function($q2) use ($authId) {
                      $q2->where('user_two', $authId)->where('archived_by_user_two', false)->where('deleted_by_user_two', false);
                  });
            })
            ->with([
                'lastMessage.sender.profile',
                'userOne.profile',
                'userTwo.profile',
                'messages' => function ($q) use ($authId) {
                    $q->where('receiver_id', $authId)
                    ->where('is_read', false)
                    ->where('is_deleted', false);
                }
            ])
            ->get();

        $archivedConversations = Conversation::where(function($q) use ($authId) {
                $q->where('user_one', $authId)->where('archived_by_user_one', true)->where('deleted_by_user_one', false)
                  ->orWhere(function($q2) use ($authId) {
                      $q2->where('user_two', $authId)->where('archived_by_user_two', true)->where('deleted_by_user_two', false);
                  });
            })
            ->with(['lastMessage.sender.profile', 'userOne.profile', 'userTwo.profile'])
            ->get();

        return view('livewire.chat-list', compact('activeConversations', 'archivedConversations'));
    }
}
