<div class="flex flex-col justify-around items-center h-full">
    <div class="w-full h-10 bg-gray-500 flex justify-end items-center">
        @if ($notification_count > 0)
            <x-heroicon-s-bell class="h-6 w-6 mr-10 text-yellow-600"/>
        @else
            <x-heroicon-o-bell class="text-white h-6 w-6 mr-10"/>
        @endif

        @dump($notification_count)

        @if (!Auth::user())
        <a href="/login" class="mr-10 text-white">Login</a>
        @endif
    </div>

    <div class="flex w-full justify-center mt-10 flex-wrap">
        <div class="max-w-xl h-96 border w-full flex flex-col"> 
            <div>Add Note</div>
            <span>Note:</span><input wire:model="note" type="text"/>
            @error('note')
                <span class="text-red-500">{{$message}}</span>
            @enderror
            <button class="bg-green-500 text-white rounded px-3 py-1" wire:click="addNote">Add</button>
        </div>

        <div class="max-w-xl h-96 border w-full flex flex-col"> 
            <div>Add Task</div>
            <span>Task:</span><input wire:model="message" type="text"/>
            @error('message')
                <span class="text-red-500">{{$message}}</span>
            @enderror
            <span>Reoccurring:</span><input type="number"/><span>minutes</span>
            <button class="bg-green-500 text-white rounded px-3 py-1" wire:click="addTaskTemplate">Add Task Template</button>
        </div>

        {{-- <div class="max-w-xl h-96 border w-full">
            <button class="bg-green-500 text-white rounded px-3 py-1">Mark Document as Approved</button>
            
            <button class="bg-yellow-500 text-white rounded px-3 py-1" wire:click="testMail">Send Test Mail</button>

            <button class="bg-blue-500 text-white rounded px-3 py-1" wire:click="testQueue">Test Queue</button> 
        </div> --}}

        <div class="max-w-xl h-96 border w-full">
            Output:
            <ul>
            @foreach (explode('||', $output) as $text)
                <li>{{$text}}</li>
            @endforeach
            <ul>
        </div>

        <div class="max-w-xl h-96 border w-full">
            Notifications:
            <ul>
            @foreach (\App\Models\Notification::all() as $notification)
                <li>{{$notification}}</li>
            @endforeach
            <ul>
        </div>
    </div>
</div>
