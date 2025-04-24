<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-white leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-4">
                <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                    <div class="cards col-span-1 lg:col-span-2">
                        <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5">
                            <div class="bg-blue-200 p-4">Item 1</div>

                            <div class="bg-green-200 p-4">Item 2</div>
                            
                            <div class="bg-yellow-200 p-4 col-span-1 lg:col-span-2">
                                Item 3
                            </div>
                        
                            <div class="bg-red-200 p-4">Item 4</div>

                            <div class="bg-purple-200 p-4">Item 5</div>
                        </div>                        
                    </div>

                    <div class="forms">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="grid gap-4 grid-cols-1 sm:grid-cols-2">
                                <div class="bg-blue-200 p-4">Item 1</div>

                                <div class="bg-green-200 p-4">Item 2</div>
                                
                                <div class="bg-yellow-200 p-4 col-span-1 lg:col-span-2">
                                    Item 3
                                </div>
                            
                                <div class="bg-red-200 p-4">Item 4</div>
    
                                <div class="bg-purple-200 p-4">Item 5</div>
                            </div>
                        </form>
                    </div>                    
                </div>                              
            </div>
        </div>
    </div>
</div>
