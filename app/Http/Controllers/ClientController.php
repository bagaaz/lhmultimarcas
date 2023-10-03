<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Helpers\Message;
use App\Http\Resources\ClientResource;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    protected $clientResource;

    public function __construct(ClientResource $resource)
    {
        $this->clientResource = new $resource;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $clients = $this->clientResource->getClients($search);
        return view('pages.clients.table', compact('clients'));
    }

    public function create()
    {
        return view('pages.clients.form');
    }

    public function store(Request $request)
    {
        //Define name as required
        $request->validate([
            'name' => 'required',
        ]);
        $data = $request->only(['id', 'name', 'cpf', 'email', 'phone', 'address']);
        $data['cpf'] = Helper::clearMaskCPF($data['cpf']);
        $data['phone'] = Helper::clearMaskPhone($data['phone']);
        $client = $this->clientResource->saveClient($data);
        if ($client === null) {
            Message::error('Cliente já cadastrado com esse CPF');
            return redirect()->route('clients.index');
        }
        Message::success('Client cadastrado com sucesso');
        return redirect()->route('clients.index');
    }

    public function edit(int $id)
    {
        $client = $this->clientResource->getClient($id);
        return view('pages.clients.form', compact('client'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $data = $request->only(['id', 'name', 'cpf', 'email', 'phone', 'address']);
        $data['cpf'] = Helper::clearMaskCPF($data['cpf']);
        $data['phone'] = Helper::clearMaskPhone($data['phone']);
        $client = $this->clientResource->saveClient($data, $id);
        Message::success('Cliente atualizado com sucesso');
        return redirect()->route('clients.index');
    }

    public function destroy(int $id)
    {
        $client = $this->clientResource->deleteClient($id);

        if ($client === null) {
            Message::error('Não é possível excluir um cliente que possui vendas');
            return redirect()->route('clients.index');
        }

        Message::success('Cliente excluído com sucesso');
        return redirect()->route('clients.index');
    }

}
