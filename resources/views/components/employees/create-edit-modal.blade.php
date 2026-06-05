@props([
  'name',
  'form',
  'editingEmployee' => null,
  'departments' => [],
  'positions' => [],
  'statuses' => [],
  'submitAction' => 'update',
  'title' => null,
  'textbutton' => 'Update',
  'modalName' => null,
  'cancelRoute' => null,
])

<flux:modal
        flyout
        variant="floating"
        name="{{ $name }}"
        class="min-w-fit px-[150px] max-w-screen min-h-screen! rounded-none! p-8!
           bg-white/10! backdrop-blur-xs! border border-white/20!
           shadow-2xl!">
  <x-employees.create-edit
          :form="$form"
          :editing-employee="$editingEmployee"
          :departments="$departments"
          :positions="$positions"
          :statuses="$statuses"
          :submit-action="$submitAction"
          :title="$title"
          :textbutton="$textbutton"
          :modal-name="$modalName ?? $name"
          :cancel-route="$cancelRoute"/>
</flux:modal>
