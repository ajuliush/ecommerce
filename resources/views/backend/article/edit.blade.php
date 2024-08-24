<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center mb-6">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Article/ Update') }}
            </h2>
            <a href="{{ route('article.index') }}" class="bg-slate-700 text-sm rounded-md text-white px-5 py-3">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('article.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="" class="text-lg font-medium">Title</label>
                            <div class="mb-3">
                                <input name="title" id="title" placeholder="Enter Name" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg @error('title') border-red-500 @enderror text-black" value="{{  old('title',$article->title) }}">
                                @error('title')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <textarea name="text" id="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg text-black" cols="38" rows="10">{{ old('text',$article->text) }}</textarea>
                            </div>
                            <label for="" class="text-lg font-medium">Author</label>
                            <div class="mb-3">
                                <input name="author" id="author" placeholder="Enter Author" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg @error('author') border-red-500 @enderror text-black" value="{{ old('author',$article->author) }}">
                                @error('author')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <button class="bg-slate-700 text-sm rounded-md text-white px-5 py-3">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
