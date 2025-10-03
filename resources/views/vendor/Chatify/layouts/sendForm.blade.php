<div class="messenger-sendCard">
    <form id="message-form" method="POST" action="{{ route('send.message') }}" enctype="multipart/form-data" class="bg-[#354657] py-4 rounded-lg">
        @csrf
        <label><span class="fas fa-plus-circle !text-white"></span><input disabled='disabled' type="file" class="upload-attachment" name="file" accept=".{{implode(', .',config('chatify.attachments.allowed_images'))}}, .{{implode(', .',config('chatify.attachments.allowed_files'))}}" /></label>
        <button class="emoji-button !text-white"></span><span class="fas fa-smile !text-white"></button>
        <textarea readonly='readonly' name="message" class="m-send app-scroll !text-white" placeholder="Type a message.."></textarea>
        <button disabled='disabled' class="send-button"><span class="fas fa-paper-plane !text-white"></span></button>
    </form>
</div>
