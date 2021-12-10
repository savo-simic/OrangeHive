<?php

namespace App\Http\Controllers\API;

use App\Exceptions\ModelNotFoundException;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class ItemController extends BaseController
{
    /*
     * Get a list of all items
     */
    public function index(): AnonymousResourceCollection
    {
        $items = Item::where('deleteflag', '!=', 1)->get();

        return ItemResource::collection($items);
    }

    /*
     * Create a new Item
     */
    public function store(Request $request): ItemResource
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $item = Item::create([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
        ]);

        return new ItemResource($item);
    }

    /*
     * Show Item by id
     */
    public function show($id): ItemResource
    {
        $item = Item::where('id', '=', $id)->where('deleteflag', '!=', 1)->first();

        if (!$item) {
            throw new ModelNotFoundException('model_not_found', trans('ui.item_not_found'), 404);
        }

        return new ItemResource($item);
    }

    /*
     * Update Item by id
     */
    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $item = Item::where('id', '=', $id)->where('deleteflag', '!=', 1)->first();

        if (!$item) {
            throw new ModelNotFoundException('model_not_found', trans('ui.item_not_found'), 404);
        }

        $item->update([
            'title' => $request->get('title'),
            'description' => $request->get('description')
        ]);

        return response()->json([
            'data' =>
                new ItemResource($item->fresh())], 200);
    }

    /*
     * Delete Item by id
     */
    public function destroy($id): JsonResponse
    {
        $item = Item::where('id', '=', $id)->where('deleteflag', '!=', 1)->first();

        if (!$item) {
            throw new ModelNotFoundException('model_not_found', trans('ui.item_not_found'), 404);
        }

        $item->update(['deleteflag' => 1]);

        return response()->json([
            'message_key'  => 'delete_success',
            'message_text' => 'Item successfully deleted.']);
    }
}
