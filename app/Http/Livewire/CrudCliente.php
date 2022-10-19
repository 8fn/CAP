<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Cliente;

class CrudCliente extends Component
{
    
    public $clientes, $nome, $email, $num_contato, $data_nascimento, $cc, $cliente_id;
    public $isModalOpen = 0;
    
    public function render()
    {
        $this->clientes = Cliente::all();
        return view('livewire.crud-cliente');
    }


    public function create(){
      $this->resetCreateForm();
      $this->openModalPopover();
    }

    public function openModalPopover(){
      $this->isModalOpen = true;
    }

    public function closeModalPopover(){
      $this->isModalOpen = false;
    }

    private function resetCreateForm(){
      $this->nome = '';
      $this->email = '';
      $this->num_contato = '';
      $this->data_nascimento = '';
      $this->cc = '';
    }

    public function store(){
      $this->validate([
        'nome' => 'required',
        'email' => 'required',
        'num_contato' => 'required',
        'data_nascimento' => 'required',
        'cc' => 'required'
      ]);

      Cliente::updateOrCreate(
        ['id' => $this->cliente_id],
        [
          'nome' => $this->nome,
          'email' => $this->email,
          'num_contato' => $this->num_contato,
          'data_nascimento' => $this->data_nascimento,
          'cc' => $this->cc

        ]
      );

      session()->flash('message', $this->cliente_id ? 'Cliente Updated.' : 'Cliente Created.');

      $this->closeModalPopover();
      $this->resetCreateForm();

    }

    public function edit($id){
      $cliente = Cliente::findOrFail($id);
      $this->cliente_id = $id;
      $this->nome = $cliente->nome;
      $this->email = $cliente->email;
      $this->num_contato = $cliente->contato;
      $this->data_nascimento = $cliente->data_nascimento;
      $this->cc = $cliente->cc;
      $this->openModalPopover();

    }

    public function delete($id){
      Cliente::find($id)->delete();
      session()->flash('message', 'Cliente delete.');
    }


}
