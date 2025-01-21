<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Product;

class BasketController extends Controller
{
    public function basket()
    {
        $order = null;
        $orderId = session('orderId');
        if (!is_null($orderId)) {
            $order = Order::findOrFail($orderId);
        }
        return view('basket', compact('order'));
    }

    public function basketPlace()
    {
        $orderId = session('orderId');
        if (is_null($orderId)) {
            return redirect(route('index'));
        }
        $order = Order::find($orderId);
        return view('order' , compact('order'));
    }

    public function basketConfirm(Request $request)
    {
        $orderId = session('orderId');
        if (is_null($orderId)) {
            return redirect(route('index'));
        }
        $order = Order::find($orderId);
        $success = $order->saveOrder($request->name, $request->phone);
        if ($success) {
          session()->flash('success', 'Спасибо, ваш заказ успешно оформлен!');
        } else {
            session()->flash('warning', 'Что-то пошло не так, пожалуйста, попробуйте еще раз');
        }
        return redirect(route('index'));
    }

    public function basketAdd($productId)
    {
      $orderId = session('orderId');
      if (is_null($orderId)) {
        $order = Order::create();
        session(['orderId' => $order->id]);
      } else {
        $order = Order::find($orderId);
      }
      if ($order->products->contains($productId)) {
        $pivotRow = $order->products()->where('product_id', $productId)->first()->pivot;
        $pivotRow->count++;
        $pivotRow->update();
      } else {
        $order->products()->attach($productId);
      }

      $product=Product::find($productId);
      session()->flash('success', 'Товар ' . $product->name . ' добавлен в корзину');
      return redirect(route('basket'));
    }

    public function basketRemove($productId)
    {
      $orderId = session('orderId');
      if (is_null($orderId)) {
        return redirect(route('basket'));
      }
      $order = Order::find($orderId);
      if ($order->products->contains($productId)) {
        $pivotRow = $order->products()->where('product_id', $productId)->first()->pivot;
        if ($pivotRow->count < 2) {
            $order->products()->detach($productId);
        } else {
            $pivotRow->count--;
            $pivotRow->update();
        }
      }
      $product=Product::find($productId);
      session()->flash('warning', 'Товар ' . $product->name . ' удален из корзины');
      return redirect(route('basket'));
    }
}