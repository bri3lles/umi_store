<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ReturnRequest extends Model { protected $table='returns'; protected $fillable=['user_id','order_id','product_id','reason','description','photo','status','refund_amount']; public function order(){return $this->belongsTo(Order::class);} public function product(){return $this->belongsTo(Product::class);} }
