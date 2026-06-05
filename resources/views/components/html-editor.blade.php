@props([
  'label',
  'model',
])

<div
  x-data="{
    value: @entangle($model),
    init() {
      this.$refs.editor.innerHTML = this.value ?? '';

      this.$watch('value', (value) => {
        if (document.activeElement !== this.$refs.editor && this.$refs.editor.innerHTML !== (value ?? '')) {
          this.$refs.editor.innerHTML = value ?? '';
        }
      });
    },
    format(command) {
      document.execCommand(command, false, null);
      this.sync();
      this.$refs.editor.focus();
    },
    sync() {
      this.value = this.$refs.editor.innerHTML;
    },
  }"
  class="w-full"
>
  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
    {{ $label }}
  </label>

  <div class="mt-1 overflow-hidden rounded-lg border border-gray-200 ring-1 ring-gray-300 dark:border-gray-400/30 dark:ring-gray-300/30">
    <div
      x-on:click.stop
      x-on:pointerdown.stop
      x-on:pointerup.stop
      class="flex flex-wrap items-center gap-1 border-b border-gray-200 bg-gray-50 p-2 dark:border-gray-400/30 dark:bg-gray-900"
    >
      <button type="button" title="{{ __('Bold') }}" x-on:mousedown.prevent x-on:click.prevent="format('bold')" class="inline-flex h-8 w-8 items-center justify-center rounded-md text-sm font-bold text-gray-700 hover:bg-white dark:text-gray-200 dark:hover:bg-gray-800">
        B
      </button>
      <button type="button" title="{{ __('Italic') }}" x-on:mousedown.prevent x-on:click.prevent="format('italic')" class="inline-flex h-8 w-8 items-center justify-center rounded-md text-sm italic text-gray-700 hover:bg-white dark:text-gray-200 dark:hover:bg-gray-800">
        I
      </button>
      <button type="button" title="{{ __('Underline') }}" x-on:mousedown.prevent x-on:click.prevent="format('underline')" class="inline-flex h-8 w-8 items-center justify-center rounded-md text-sm underline text-gray-700 hover:bg-white dark:text-gray-200 dark:hover:bg-gray-800">
        U
      </button>
      <button type="button" title="{{ __('Bulleted list') }}" x-on:mousedown.prevent x-on:click.prevent="format('insertUnorderedList')" class="inline-flex h-8 w-8 items-center justify-center rounded-md text-sm text-gray-700 hover:bg-white dark:text-gray-200 dark:hover:bg-gray-800">
        <flux:icon name="list-bullet" class="h-4 w-4" />
      </button>
      <button type="button" title="{{ __('Numbered list') }}" x-on:mousedown.prevent x-on:click.prevent="format('insertOrderedList')" class="inline-flex h-8 w-8 items-center justify-center rounded-md text-sm text-gray-700 hover:bg-white dark:text-gray-200 dark:hover:bg-gray-800">
        <flux:icon name="numbered-list" class="h-4 w-4" />
      </button>
    </div>

    <div
      x-ref="editor"
      contenteditable="true"
      x-on:input="sync"
      x-on:blur="sync"
      class="html-editor-content min-h-36 w-full bg-white px-4 py-3 text-sm text-gray-800 outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-neutral-200 dark:focus:ring-neutral-600"
    ></div>
  </div>

  @error($model)
    <p class="mt-1 text-sm text-red-600!">{{ $message }}</p>
  @enderror
</div>
