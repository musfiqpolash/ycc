<?php

namespace App\Http\Controllers;

use App\Model\Product;
use App\Model\ProductImage;
use App\Model\ProductPrice;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add($accessories)
    {
        //dd((int)$accessories);
        if ((int)$accessories === 0 || (int)$accessories === 1) {
            $data['access'] = (int)$accessories;
            return view('backend.pages.product.add', $data);
        }
    }
    public function create(Request $r)
    {
			if ($_POST){
				//dd($r->all());
//				dd($r->image[0]->extension());
				do {
					$t_grp = substr(uniqid(), 0, 15);
					$yy = Product::where('group_name', $t_grp)->get();
					$vv = sizeof($yy);
				} while ($vv != 0);

				$condition = $r->input('condition');
				$memory = $r->input('memory');
				$color = $r->input('color');
				$stock = $r->input('stock');
				$product_label = $r->input('product_label');
				$min_quantity=$r->input('min_quantity');
				$max_quantity=$r->input('max_quantity');
				$price=$r->input('price');
				$c_name=$r->input('c_name');
				$c_description=$r->input('c_description');
				$description=$r->input('description');

				foreach ($condition as $k => $res) {
					do {
						$t_pcode = $r->input('product_category') . mt_rand(1000, 9999);
						$yyy = Product::where('p_code', $t_pcode)->get();
						$vvv = sizeof($yyy);
					} while ($vvv != 0);
					$p = new Product();
					$p->main_image = 'no-img.png';
					$p->name = strtoupper($r->input('product_name'));
					$p->product_condition=$condition[$k];
					$p->group_name = $t_grp;
					$p->category = $r->input('product_category');
					$p->is_accessories = 1;
					$p->p_code = $t_pcode;

					$p->size = strtoupper($memory[$k]);
					$p->color = strtoupper($color[$k]);
					$p->quantity = $stock[$k];
					$p->description = $description[$k];

					foreach ($c_name[$k] as $kk => $c_val) {
						$c_dtls[$kk]['name'] = $c_name[$k][$kk];
						$c_dtls[$kk]['description'] = $c_description[$k][$kk];
					}
					$p->carrier_details = json_encode($c_dtls);

					$p->is_discount = 0;
					$p->discount_price = 0;
					if ($product_label[$k] == '0') {
						$p->label = '';
						$p->label_css = '';
					} else {
						$p->label = $product_label[$k];
						$p->is_discount = 1;
						$p->discount_price = '0.0'; //$tmpDisP[$k];
						if ($p->label == 'ON SALE') {
							$p->label_css = 'colorSale';
						} elseif ($p->label == 'LIMITED EDITION') {
							$p->label_css = 'colorLimited';
						} elseif ($p->label == 'NEW') {
							$p->label_css = 'colorNEW';
						}
					}

					$p->status = 1;
					$p->created_at = date('Y-m-d');
					$p->save();
					$currId = $p->id;

					foreach ($price[$k] as $j=>$jj){
						$p_price=new ProductPrice();
						$p_price->product_id=$currId;
						$p_price->min_quantity=$min_quantity[$k][$j];
						$p_price->max_quantity=$max_quantity[$k][$j];
						$p_price->price=$price[$k][$j];
						$p_price->save();
					}

					$imgName='main_image_' . $currId . '.' . $r->image[$k]->getClientOriginalExtension();
					$image = Image::make($r->image[$k]);
					$image->widen(263);
					Storage::disk('public_uploads')->put($imgName, (string) $image->encode());
					$p->main_image = $imgName;
					$p->save();


					$thum_img='thum_image_' . $currId . '_0.' . '.' . $r->image[$k]->getClientOriginalExtension();
					$image1 = Image::make($r->image[$k]);
					$image1->resize(50,50);
					Storage::disk('public_uploads')->put($thum_img, (string) $image1->encode());

					$main_img='details_main_img_' . $currId . '_0.' . '.' . $r->image[$k]->getClientOriginalExtension();
					$image2 = Image::make($r->image[$k]);
					$image2->widen(480);
					Storage::disk('public_uploads')->put($main_img, (string) $image2->encode());

					$zoom_img='zoom_img_' . $currId . '_.'  . $r->image[$k]->getClientOriginalExtension();
					$image3 = Image::make($r->image[$k]);
					$image3->widen(1024);
					Storage::disk('public_uploads')->put($zoom_img, (string) $image3->encode());

					$pi = new ProductImage();
					$pi->product_id = $currId;
					$pi->status = 1;
					$pi->main_img = $main_img;
					$pi->color_img = $thum_img;
					$pi->thum_img = $thum_img;
					$pi->zoom_img = $zoom_img;
					$pi->created_at = date('Y-m-d');
					$pi->save();

				}
				return redirect('admin/');
			}
            $data['access']=1;
            return view('backend.pages.product.create_new',$data);
    }

    public function post(\App\Http\Requests\Product $r)
    {
        do {
            $t_grp = substr(uniqid(), 0, 15);
            $yy = Product::where('group_name', $t_grp)->get();
            $vv = sizeof($yy);
        } while ($vv != 0);

        $tmpSize = $r->input('product_size');
        $tmpColor = $r->input('product_color');
        $tmpPrice = $r->input('product_price');
        $tmpQty = $r->input('product_quantity');
        $tmplabel = $r->input('product_label');
        $tmpDisP = '';////$r->input('product_discount_price');
        $tmpDscrptn = $r->input('product_description');
        $tmpAcc = $r->input('is_accessories');

        $totalErr = array();
        $ttl_cuntr = 0;
        foreach ($tmpSize as $k => $res) {
            do {
                $t_pcode = $r->input('product_category') . mt_rand(1000, 9999);
                $yyy = Product::where('p_code', $t_pcode)->get();
                $vvv = sizeof($yyy);
            } while ($vvv != 0);
            $p = new Product();
            $p->main_image = 'no-img.png';
            $p->name = ucfirst($r->input('product_name'));
            $p->group_name = $t_grp;
            $p->category = $r->input('product_category');
            $p->is_accessories = $r->input('is_accessories');
            $p->p_code = $t_pcode;

            $p->size = strtoupper($tmpSize[$k]);
            $p->color = strtoupper($tmpColor[$k]);
            $p->price = $tmpPrice[$k];
            $p->quantity = $tmpQty[$k];
            $p->description = $tmpDscrptn;

            $p->carrier_details = '';
            if ($r->has('carrierName')) {
                $t_c_name = $r->input('carrierName');
                $t_c_des = $r->input('carrierDescription');
                $c_dtls = array();
                foreach ($t_c_name as $kk => $c_val) {
                    $c_dtls[$kk]['name'] = $t_c_name[$kk];
                    $c_dtls[$kk]['description'] = $t_c_des[$kk];
                }
                $p->carrier_details = json_encode($c_dtls);
            }
            $p->is_discount = 0;
            $p->discount_price = 0;
            if ($tmplabel[$k] == '0') {
                $p->label = '';
                $p->label_css = '';
            } else {
                $p->label = $tmplabel[$k];
                $p->is_discount = 1;
                $p->discount_price = '0.0'; //$tmpDisP[$k];
                if ($p->label == 'ON SALE') {
                    $p->label_css = 'colorSale';
                } elseif ($p->label == 'LIMITED EDITION') {
                    $p->label_css = 'colorLimited';
                } elseif ($p->label == 'NEW') {
                    $p->label_css = 'colorNEW';
                }
            }

            $p->status = 1;
            $p->created_at = date('Y-m-d');
            $p->save();
            $currId = $p->id;

            /****Img up****/
            //main for home
            if ($r->has('product_image')) {
                $imageName = 'main_image_' . $currId . '.' . $r->product_image[$k]->getClientOriginalExtension();

                $err = $r->product_image[$k]->move(public_path('uploads/assets/frontend/images/products/'), $imageName);
                if ($err) {
                    Product::where('id', $currId)->update(['main_image' => $imageName]);
                } else {
                    $totalErr[$ttl_cuntr++] = 'Err (' + $imageName + ')';
                }

            }

            //details thum
            if ($r->has('product_details_image1')) {
                //foreach ($r->input('product_details_image1') as $thunCn => $thumV) {
                $imageName = 'thum_image_' . $currId . '_0.' . $r->product_details_image1[$k]->getClientOriginalExtension();

                $err = $r->product_details_image1[$k]->move(public_path('uploads/assets/frontend/images/products/'), $imageName);
                if ($err) {
                    $pi = new ProductImage();
                    $pi->product_id = $currId;
                    $pi->status = 1;
                    $pi->main_img = 'no-img.png';
                    $pi->color_img = $imageName;
                    $pi->thum_img = $imageName;
                    $pi->zoom_img = 'no-img.png';
                    $pi->created_at = date('Y-m-d');
                    $pi->save();
                } else {
                    $totalErr[$ttl_cuntr++] = 'Err (' + $imageName + ')';
                }
                // }
            }
            //details main
            if ($r->has('product_details_image2')) {
                //foreach ($r->has('product_details_image2') as $thunCn => $thumV) {
                $imageName = 'details_main_img_' . $currId . '_0.' . $r->product_details_image2[$k]->getClientOriginalExtension();

                $err = $r->product_details_image2[$k]->move(public_path('uploads/assets/frontend/images/products/'), $imageName);
                if ($err) {
                    ProductImage::where('product_id', $currId)->update(['main_img' => $imageName]);
                } else {
                    $totalErr[$ttl_cuntr++] = 'Err (' + $imageName + ')';
                }
                // }
            }
            //zoom
            if ($r->has('product_details_image3')) {
                //foreach ($r->has('product_details_image3') as $thunCn => $thumV) {
                $imageName = 'zoom_img_' . $currId . '_.' . $r->product_details_image3[$k]->getClientOriginalExtension();

                $err = $r->product_details_image3[$k]->move(public_path('uploads/assets/frontend/images/products/'), $imageName);
                if ($err) {
                    ProductImage::where('product_id', $currId)->update(['zoom_img' => $imageName]);
                } else {
                    $totalErr[$ttl_cuntr++] = 'Err (' + $imageName + ')';
                }
                //}
            }

        }
        return redirect('admin/product/list/' . $tmpAcc)->with('warning', $totalErr);
    }

    public function postAdd(\App\Http\Requests\productAdd $r)
    {
        //dd($r);
        $tmpSize = $r->input('product_size');
        $tmpColor = $r->input('product_color');
        $tmpPrice = $r->input('product_price');
        $tmpQty = $r->input('product_quantity');
        $tmplabel = $r->input('product_label');
        $t_grp = $r->input('group_name');
        $tmpDisP = '';////$r->input('product_discount_price');
        $tmpProduct = Product::where('group_name', $t_grp)->get();
        //dd($tmpProduct);
        $totalErr = array();
        $ttl_cuntr = 0;
        foreach ($tmpSize as $k => $res) {
            do {
                $t_pcode = $r->input('product_category') . mt_rand(1000, 9999);
                $yyy = Product::where('p_code', $t_pcode)->get();
                $vvv = sizeof($yyy);
            } while ($vvv != 0);
            $p = new Product();
            $p->main_image = 'no-img.png';
            $p->name = $tmpProduct[0]->name;
            $p->group_name = $t_grp;
            $p->category = $tmpProduct[0]->category;
            $p->is_accessories = $tmpProduct[0]->is_accessories;
            $p->p_code = $t_pcode;

            $p->size = strtoupper($tmpSize[$k]);
            $p->color = strtoupper($tmpColor[$k]);
            $p->price = $tmpPrice[$k];
            $p->quantity = $tmpQty[$k];
            $p->description = $tmpProduct[0]->description;

            $p->carrier_details = $tmpProduct[0]->carrier_details;

            $p->is_discount = 0;
            $p->discount_price = 0;
            if ($tmplabel[$k] == '0') {
                $p->label = '';
                $p->label_css = '';
            } else {
                $p->label = $tmplabel[$k];
                $p->is_discount = 1;
                $p->discount_price = '0.0'; //$tmpDisP[$k];
                if ($p->label == 'ON SALE') {
                    $p->label_css = 'colorSale';
                } elseif ($p->label == 'LIMITED EDITION') {
                    $p->label_css = 'colorLimited';
                } elseif ($p->label == 'NEW') {
                    $p->label_css = 'colorNEW';
                }
            }

            $p->status = 1;
            $p->created_at = date('Y-m-d');
            $p->save();
            $currId = $p->id;

            /****Img up****/
            //main for home
            if ($r->has('product_image')) {
                $imageName = 'main_image_' . $currId . '.' . $r->product_image[$k]->getClientOriginalExtension();

                $err = $r->product_image[$k]->move(public_path('uploads/assets/frontend/images/products/'), $imageName);
                if ($err) {
                    Product::where('id', $currId)->update(['main_image' => $imageName]);
                } else {
                    $totalErr[$ttl_cuntr++] = 'Err (' + $imageName + ')';
                }

            }

            //details thum
            if ($r->has('product_details_image1')) {
                //foreach ($r->input('product_details_image1') as $thunCn => $thumV) {
                $imageName = 'thum_image_' . $currId . '_0.' . $r->product_details_image1[$k]->getClientOriginalExtension();

                $err = $r->product_details_image1[$k]->move(public_path('uploads/assets/frontend/images/products/'), $imageName);
                if ($err) {
                    $pi = new ProductImage();
                    $pi->product_id = $currId;
                    $pi->status = 1;
                    $pi->main_img = 'no-img.png';
                    $pi->color_img = $imageName;
                    $pi->thum_img = $imageName;
                    $pi->zoom_img = 'no-img.png';
                    $pi->created_at = date('Y-m-d');
                    $pi->save();
                } else {
                    $totalErr[$ttl_cuntr++] = 'Err (' + $imageName + ')';
                }
                // }
            }
            //details main
            if ($r->has('product_details_image2')) {
                //foreach ($r->has('product_details_image2') as $thunCn => $thumV) {
                $imageName = 'details_main_img_' . $currId . '_0.' . $r->product_details_image2[$k]->getClientOriginalExtension();

                $err = $r->product_details_image2[$k]->move(public_path('uploads/assets/frontend/images/products/'), $imageName);
                if ($err) {
                    ProductImage::where('product_id', $currId)->update(['main_img' => $imageName]);
                } else {
                    $totalErr[$ttl_cuntr++] = 'Err (' + $imageName + ')';
                }
                // }
            }
            //zoom
            if ($r->has('product_details_image3')) {
                //foreach ($r->has('product_details_image3') as $thunCn => $thumV) {
                $imageName = 'zoom_img_' . $currId . '_.' . $r->product_details_image3[$k]->getClientOriginalExtension();

                $err = $r->product_details_image3[$k]->move(public_path('uploads/assets/frontend/images/products/'), $imageName);
                if ($err) {
                    ProductImage::where('product_id', $currId)->update(['zoom_img' => $imageName]);
                } else {
                    $totalErr[$ttl_cuntr++] = 'Err (' + $imageName + ')';
                }
                //}
            }

        }
        return back()->with('warning', $totalErr);
    }

    public function lists($accessories = 1)
    {
        $tmp = Product::where('status', 1)
            ->where('is_accessories', $accessories)
            ->orderBy('category')
            ->orderBy('color')
            ->get();
        $data['page_data'] = $tmp->groupBy('group_name');
        $data['access'] = (int)$accessories;
        //dd($data);
        return view('backend.pages.product.list', $data);
    }

    public function details($grp, $accessories)
    {
        $data['access'] = (int)$accessories;
        $data['page_data'] = Product::with(['hasImage' => function ($q) {
            $q->where('status', 1);
        }])
            ->where('group_name', $grp)
            ->where('status', 1)
            ->where('is_accessories', $accessories)
            ->get();
        //dd($data['page_data'][0]->main_image);
        if (sizeof($data['page_data']) == 0) {
            return back()->with('danger', 'Something went wrong. Please try Properly');
        } else {
            return view('backend.pages.product.details', $data);
        }
    }

    public function destroy(Request $r)
    {
        $upD['status'] = 0;
        $tmp = Product::where('group_name', $r->input('productId'))->get(['id']);
        Product::whereIn('id', $tmp)
            ->update($upD);
        ProductImage::whereIn('product_id', $tmp)
            ->update($upD);

        return back()->with('success', 'Product Has Been Deleted');
    }

    public function edit($grp, $accessories)
    {
        $data['access'] = (int)$accessories;
        $data['page_data'] = Product::with(['hasImage' => function ($q) {
            $q->where('status', 1);
        }])
            ->where('group_name', $grp)
            ->where('status', 1)
            ->where('is_accessories', $accessories)
            ->get();
        //dd($data['page_data'][0]->main_image);
        if (sizeof($data['page_data']) == 0) {
            return back()->with('danger', 'Something went wrong. Please try Properly');
        } else {
            //dd($data);
            return view('backend.pages.product.edit', $data);
        }
    }

    public function update(\App\Http\Requests\Product $r)
    {
        //dd($r);
        $tmpSize = $r->input('product_size');
        $tmpColor = $r->input('product_color');
        $tmpPrice = $r->input('product_price');
        $tmpQty = $r->input('product_quantity');
        $tmplabel = $r->input('product_label');
        $tmpDisP = '';////$r->input('product_discount_price');
        $tmpDscrptn = $r->input('product_description');
        $tmpId = $r->input('pro_id');

        foreach ($tmpSize as $k => $res) {
            $p['name'] = ucfirst($r->input('product_name'));
            $p['category'] = $r->input('product_category');
            $p['is_accessories'] = $r->input('is_accessories');

            $p['size'] = strtoupper($tmpSize[$k]);
            $p['color'] = strtoupper($tmpColor[$k]);
            $p['price'] = $tmpPrice[$k];
            $p['quantity'] = $tmpQty[$k];
            $p['description'] = $tmpDscrptn;

            $p['carrier_details'] = '';
            if ($r->has('carrierName')) {
                $t_c_name = $r->input('carrierName');
                $t_c_des = $r->input('carrierDescription');
                $c_dtls = array();
                foreach ($t_c_name as $kk => $c_val) {
                    $c_dtls[$kk]['name'] = $t_c_name[$kk];
                    $c_dtls[$kk]['description'] = $t_c_des[$kk];
                }
                $p['carrier_details'] = json_encode($c_dtls);
            }
            $p['is_discount'] = 0;
            $p['discount_price'] = 0;
            if ($tmplabel[$k] == '0') {
                $p['label'] = '';
                $p['label_css'] = '';
            } else {
                $p['label'] = $tmplabel[$k];
                $p['is_discount'] = 1;
                $p['discount_price'] = '0.0'; //$tmpDisP[$k];
                if ($p['label'] == 'ON SALE') {
                    $p['label_css'] = 'colorSale';
                } elseif ($p['label'] == 'LIMITED EDITION') {
                    $p['label_css'] = 'colorLimited';
                } elseif ($p['label'] == 'NEW') {
                    $p['label_css'] = 'colorNEW';
                }
            }
            Product::where('id', $tmpId[$k])->update($p);
            //$a[$k]=$p;
        }
        //dd($a);
        return back()->with('success', 'Product Has Been Updated');
    }

    public function updateImage(Request $r)
    {
        $oldImg = $r->input('oldImg');
        $totalErr = array();
        $ttl_cuntr = 0;
        $currId = $r->input('proId');
        //main for home
        if ($r->has('product_image')) {
            $imageName = 'main_image_' . $currId . '.' . $r->product_image[0]->getClientOriginalExtension();
            //dd($imageName);
            $err = $r->product_image[0]->move(public_path('uploads/assets/frontend/images/products/'), $imageName);
            //dd($err);
            if ($err) {
                Product::where('id', $currId)->update(['main_image' => $imageName]);
            } else {
                $totalErr[$ttl_cuntr++] = 'Err (' + $imageName + ')';
            }

        }

        //details thum
        if ($r->has('product_details_image1')) {
            //foreach ($r->input('product_details_image1') as $thunCn => $thumV) {
            $imageName = 'thum_image_' . $currId . '_0.' . $r->product_details_image1[0]->getClientOriginalExtension();

            $err = $r->product_details_image1[0]->move(public_path('uploads/assets/frontend/images/products/'), $imageName);
            if ($err) {
                $a['color_img'] = $imageName;
                $a['thum_img'] = $imageName;
                ProductImage::where('product_id', $currId)->update($a);
            } else {
                $totalErr[$ttl_cuntr++] = 'Err (' + $imageName + ')';
            }

            // }
        }
        //details main
        if ($r->has('product_details_image2')) {
            //foreach ($r->has('product_details_image2') as $thunCn => $thumV) {
            $imageName = 'details_main_img_' . $currId . '_0.' . $r->product_details_image2[0]->getClientOriginalExtension();

            $err = $r->product_details_image2[0]->move(public_path('uploads/assets/frontend/images/products/'), $imageName);
            if ($err) {
                ProductImage::where('product_id', $currId)->update(['main_img' => $imageName]);
            } else {
                $totalErr[$ttl_cuntr++] = 'Err (' + $imageName + ')';
            }

            // }
        }
        //zoom
        if ($r->has('product_details_image3')) {
            //foreach ($r->has('product_details_image3') as $thunCn => $thumV) {
            $imageName = 'zoom_img_' . $currId . '_.' . $r->product_details_image3[0]->getClientOriginalExtension();

            $err = $r->product_details_image3[0]->move(public_path('uploads/assets/frontend/images/products/'), $imageName);
            if ($err) {
                ProductImage::where('product_id', $currId)->update(['zoom_img' => $imageName]);
            } else {
                $totalErr[$ttl_cuntr++] = 'Err (' + $imageName + ')';
            }
        }
        //dd($totalErr);
        return back()->with('warning', $totalErr);
    }

    public function get_info()
    {
        $tmp = Product::where('name', $_GET['name'])->get(['group_name']);
        if ($tmp->count()) $a = 'present'; else $a = 'absent';
        return $a;
    }

    public function resetPassword()
    {
        $this->validate(request(), [
            'password' => 'required|min:6|confirmed'
        ]);
        $pass['password'] = bcrypt($_POST['password']);
        //dd($pass);
        User::where('id', session('login_id'))->update($pass);
        return back()->with('success', 'Password Changed');
    }
}
	