<div class="flex flex-col justify-around items-center h-full">
    <div class="w-full h-10 bg-gray-500 flex justify-end items-center">
        <x-heroicon-o-bell class="text-white h-6 w-6 mr-10"/>
        @if (!Auth::user())
        <a href="/login" class="mr-10 text-white">Login</a>
        @endif
    </div>

    <div class="flex w-full justify-center mt-10">
        <div class="max-w-xl h-96 border w-full"> 
            <div>Add Task</div>
            <input type="date"/>
        </div>

        <div class="max-w-xl h-96 border w-full">
            <button class="bg-green-500 text-white rounded px-3 py-1">Mark Document as Approved</button>
            
            <button class="bg-yellow-500 text-white rounded px-3 py-1" wire:click="testMail">Send Test Mail</button>

            <button class="bg-blue-500 text-white rounded px-3 py-1" wire:click="testQueue">Test Queue</button>

            
        </div>

        <div class="max-w-xl h-96 border w-full">
            Output:
        </div>
    </div>
</div>
