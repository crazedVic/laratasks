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
            <span>Task:</span><input wire:model="title" type="text"/>
            @error('title')
                <span class="text-red-500">{{$message}}</span>
            @enderror

            <div>Frequency</div>
            <select wire:model="frequency">
                <option value="">Please select</option>
                <option value="none">None</option>
                <option value="weekly">Weekly</option>
                <option value="bi-weekly">Bi-Weekly</option>
                <option value="monthly">Monthly</option>
                <option value="quarterly">Quarterly</option>
            </select>
            @error('frequency')
                <span class="text-red-500">{{$message}}</span>
            @enderror

            @if ($frequency == "weekly" || $frequency == "bi-weekly")
                <div>Weekday</div>
                <select wire:model="day">
                    <option value="">Please select</option>
                    <option value="0">Sunday</option>
                    <option value="1">Monday</option>
                    <option value="2">Tuesday</option>
                    <option value="3">Wednesday</option>
                    <option value="4">Thursday</option>
                    <option value="5">Friday</option>
                    <option value="6">Saturday</option>
                </select>
            @elseif ($frequency != "none" && $frequency != "")
                <div>Day of Month</div>
                <input type="number" wire:model="day" max="29" min="0"/>
            @endif
            @error('day')
                <span class="text-red-500">{{$message}}</span>
            @enderror

            <button class="bg-green-500 text-white rounded px-3 py-1" wire:click="addTask">Add Task</button>
        </div>

        <div class="max-w-xl h-96 border w-full">
            {{-- <button class="bg-green-500 text-white rounded px-3 py-1">Mark Document as Approved</button>
            
            <button class="bg-yellow-500 text-white rounded px-3 py-1" wire:click="testMail">Send Test Mail</button>

            <button class="bg-blue-500 text-white rounded px-3 py-1" wire:click="testQueue">Test Queue</button> 

            <button class="bg-green-500 text-white rounded px-3 py-1">Mark Document as Approved</button>
            
            <button class="bg-yellow-500 text-white rounded px-3 py-1" wire:click="testMail">Send Test Mail</button> --}}

            <button class="bg-blue-500 text-white rounded px-3 py-1" wire:click="carbonTest">Carbon Test</button> 
        </div>

        <div class="max-w-xl h-96 border w-full">
            Tasks:
            @foreach (\App\Models\Task::all() as $task)
                {{$task}}
            @endforeach
        </div>

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
                <li class="truncate">{{json_decode($notification->data)->message}}</li>
            @endforeach
            <ul>
        </div>
    </div>
</div>
