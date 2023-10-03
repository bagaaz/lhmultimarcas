<?php

namespace App\Http\Resources;

use App\Models\Client;

class ClientResource
{
    public function getClients(string $search = null)
    {
        $clients = Client::orderBy('name', 'asc');
        if ($search) {
            $clients->where('name', 'like', "%{$search}%")
                ->orWhere('cpf', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('address', 'like', "%{$search}%");
        }

        return $clients->paginate(10);
    }

    public function getClient(int $id)
    {
        return Client::findOrFail($id);
    }

    public function saveClient(array $data, int $id = null)
    {
        if ($id) {
            $client = Client::find($id);
            $client->update($data);
        } else {
            $existingClient = Client::where('cpf', $data['cpf'])->first();
            if ($existingClient) {
                return null;
            }
            $client = Client::create($data);
        }
        return $client;
    }

    public function deleteClient(int $id)
    {
        $client = Client::find($id);

        $clientSales = $client->sales()->get();
        if ($clientSales->count() > 0) {
            return null;
        }

        $client->delete();
        return $client;
    }
}
