<div class="flex flex-col justify-around items-center h-full">
    <div class="w-full h-10 bg-gray-500 flex justify-end items-center">
        <x-heroicon-o-bell class="text-white h-6 w-6 mr-10"/>
        @if (!Auth::user())
        <a href="/login" class="mr-10 text-white">Login</a>
        @endif
    </div>

    <div class="flex w-full justify-center mt-10">
        <div class="max-w-xl h-96 border w-full flex flex-col"> 
            <div>Add Task</div>
            <span>Date:</span><input wire:model="date" type="date"/>
            @error('date')
                <span class="text-red-500">{{$message}}</span>
            @enderror
            <span>Task:</span><input wire:model="message" type="text"/>
            @error('message')
                <span class="text-red-500">{{$message}}</span>
            @enderror
            <button class="bg-green-500 text-white rounded px-3 py-1" wire:click="addTask">Add</button>
        </div>

        <div class="max-w-xl h-96 border w-full">
            <button class="bg-green-500 text-white rounded px-3 py-1">Mark Document as Approved</button>
            
            <button class="bg-yellow-500 text-white rounded px-3 py-1" wire:click="testMail">Send Test Mail</button>

            <button class="bg-blue-500 text-white rounded px-3 py-1" wire:click="testQueue">Test Queue</button>

            
        </div>

        <div class="max-w-xl h-96 border w-full">
            Output:
            <ul>
            @foreach (explode('||', $output) as $text)
                <li>{{$text}}</li>
            @endforeach
            <ul>
        </div>
    </div>
</div>
