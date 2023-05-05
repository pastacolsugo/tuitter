<div class="mt-2 bg-white dark:bg-black dark:text-white border-b border-t sm:border-x border-neutral-300 dark:border-neutral-800">
    <form method="post" action="/post" enctype="multipart/form-data">
        <div class="p-2 pt-4 sm:p-4 px-4 sm:px-6 flex justify-start border-neutral-300 dark:border-neutral-800">
            <a href="{{ route('profile', Auth::id())}}">
                <figure class="mr-3 sm:mr-4 w-10 h-10 sm:w-14 sm:h-14 bg-black border-white object-scale-down overflow-hidden rounded-full shrink-0 flex flex-col justify-center select-none">
                    <img src="{{ route('profile_pic', Auth::id()) }}" class="max-h-20 object-contain" alt="" longdesc="">
                </figure>
            </a>
            <div class="max-w-[85%] grow">
                <div class="text-md sm:text-lg cursor-default break-words">
                    <label for="tuit-input" class="hidden">Scrivi un tuit:</label>
                    <textarea
                        id="tuit-input"
                        name="content"
                        placeholder="A cosa stai pensando?"
                        rows="4"
                        class="w-[100%] h-[80px] p-2 border border-neutral-300 dark:border-neutral-800 bg-white dark:bg-black"
                        required></textarea>
                </div>
                <div id="image-description-container" class="hidden">
                    <label for="image-description" class="hidden">Descrivi l'immagine per chi non vede.</label>
                    <input
                        type="text"
                        id="image-description"
                        name="image_description"
                        placeholder="Descrizione immagine..."
                        class="w-[100%] h-[40px] p2 border border-neutral-300 dark:border-neutral-800 bg-white dark:bg-black" />
                </div>
                <div class="flex gap-4 mt-4 justify-between text-gray-500 font-light">
                    <label for="image-upload" class="hidden">
                        Upload image
                    </label>
                    <input id="image-upload" name="image_upload" type="file" accept=".jpeg,.jpg,.png,.webp" class=""/>
                    <button type="submit" class="py-2 px-4 border-2 border-neutral-300 dark:text-neutral-300 dark:border-neutral-300 font-bold">Pubblica</button>
                </div>
            </div>
        </div>
    </form>
</div>
