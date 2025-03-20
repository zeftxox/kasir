<?php

namespace App\Http\Livewire\Admin\Categories;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Session;

class ManageCategories extends Component
{
    public $categories, $kategori, $category_id, $search;
    public $isOpen = false; // Untuk mengontrol popup
    

    protected $rules = [
        'kategori' => 'required|string|max:255'
    ];

    protected $listeners = [
        'confirmDeleteCategories' => 'delete',
    ];

    public function render()
    {
        $query = Category::query();
        $query->where('kategori', 'like', '%' . $this->search . '%');
        $this->categories = $query->get();
        return view('livewire.admin.categories.manage-categories');
    }

    public function openModal()
    {
        $this->resetInput();
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInput()
    {
        $this->kategori = '';
        $this->category_id = null;
    }

    public function store()
    {
        $this->validate();
        
        Category::create(['kategori' => $this->kategori]);

        Session::flash('success', 'Kategori berhasil ditambahkan');
        $this->closeModal();
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->category_id = $id;
        $this->kategori = $category->kategori;
        $this->isOpen = true;
    }
    

    public function update()
    {
        $this->validate();

        $category = Category::findOrFail($this->category_id);
        $category->update(['kategori' => $this->kategori]);

        Session::flash('success', 'Kategori berhasil diperbarui');
        $this->closeModal();
    }

    public function delete($id)
    {
        Category::findOrFail($id)->delete();
        Session::flash('success', 'Kategori berhasil dihapus');
    }
}
