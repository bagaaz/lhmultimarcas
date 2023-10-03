<?php

namespace App\Http\Controllers\Products;

use App\Helpers\Message;
use App\Http\Controllers\Controller;
use App\Models\Product\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function save(Request $request)
    {
        $data = $request->only(['id', 'name']);
        $isNew = !isset($data['id']);
        if ($isNew) {
            $color = Color::create($data);
            Message::success('Cor cadastrada com sucesso');
        } else {
            $color = Color::find($data['id']);
            $color->update($data);
            Message::success('Cor atualizada com sucesso');
        }

        return redirect()->route('products.create');
    }

    public function delete(int $id)
    {
        $color = Color::find($id);
        if (!$color) {
            Message::error('Não foi possível excluir a cor');
            return json_encode(['success' => false]);
        }
        $color->delete();
        Message::success('Cor excluída com sucesso');
        return json_encode(['success' => true]);
    }
}
