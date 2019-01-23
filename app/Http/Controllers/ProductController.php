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

    public function create($type, $p_group = null)
    {
        if ($p_group) {
            $product = Product::where('group_name', $p_group)->select('name', 'group_name', 'category', 'sub_category_id')->firstOrFail();
            //dd($product);
            $data['product'] = $product;
        }
        if ($type == 'product') {
            $data['access'] = 1;
            return view('backend.pages.product.create_new', $data);
        } elseif ($type == 'accessories') {
            $data['access'] = 0;
            $category = Product::where('status', 1)->get(['name']);
            $data['category'] = $category->groupBy('name');

            return view('backend.pages.product.create_access', $data);
        } else {
            return redirect('page_not_found');
        }
    }

    protected function insert_product(Request $r)
    {
        // dd($r->all());
        //				dd($r->image[0]->extension());
        if ($r->has('group_name')) {
            $t_grp = $r->input('group_name');
        } else {
            do {
                $t_grp = substr(uniqid(), 0, 15);
                $yy = Product::where('group_name', $t_grp)->get();
                $vv = sizeof($yy);
            } while ($vv != 0);
        }

        $condition = $r->input('condition');
        $memory = $r->input('memory');
        $color = $r->input('color');
        $stock = $r->input('stock');
        $product_label = $r->input('product_label');
        $min_quantity = $r->input('min_quantity');
        $max_quantity = $r->input('max_quantity');
        $price = $r->input('price');
        $c_name = $r->input('c_name');
        $c_description = $r->input('c_description');
        $description = $r->input('description');

        $cur_price = $price[0];
        $cur_min_qu = 1;
        $cur_max_qu = 1;

        $cur_img = $r->image[0];

        $cur_desc = $description[0];

        $cur_c_name = $c_name[0];
        $cur_c_desc = $c_description[0];

        foreach ($condition as $k => $res) {
            do {
                $t_pcode = str_replace(" ", "_", $r->input('product_category')) . mt_rand(1000, 9999);
                $yyy = Product::where('p_code', $t_pcode)->get();
                $vvv = sizeof($yyy);
            } while ($vvv != 0);
            $p = new Product();
            $p->main_image = 'no-img.png';
            $p->name = strtoupper($r->input('product_name'));
            $p->product_condition = $condition[$k];
            $p->group_name = $t_grp;
            $p->category = $r->input('product_category');
            $p->sub_category_id = $r->input('product_sub_category');
            $p->is_accessories = $r->input('is_accessories');
            $p->p_code = $t_pcode;

            $p->size = strtoupper($memory[$k]);
            $p->color = strtoupper($color[$k]);
            $p->quantity = $stock[$k];
            if ($r->same_desc && !empty($r->same_desc[$k])) {
            } else {
                $cur_desc = $description[$k];
            }
            $p->description = $cur_desc;

            if ($r->same_carrier && !empty($r->same_carrier[$k])) {
            } else {
                $cur_c_name = $c_name[$k];
                $cur_c_desc = $c_description[$k];
            }
            $c_dtls = null;
            foreach ($cur_c_name as $kk => $c_val) {
                if (!empty($cur_c_name[$kk]) && !empty($cur_c_desc[$kk])) {
                    $c_dtls[$kk]['name'] = $cur_c_name[$kk];
                    $c_dtls[$kk]['description'] = $cur_c_desc[$kk];
                }
            }
            if (isset($c_dtls) && !empty($c_dtls)) {
                $p->carrier_details = json_encode($c_dtls);
            }

            $p->is_discount = 0;
            $p->discount_price = 0;
            if ($product_label[$k] == '0' || sizeof($product_label) == 0) {
                $p->label = '';
                $p->label_css = '';
            } else {
                $p->label = $product_label[$k];
                if ($p->label == 'ON SALE') {
                    $p->label_css = 'colorSale';
                    $p->is_discount = 1;
                    $p->discount_price = '0.0'; //$tmpDisP[$k];
                } elseif ($p->label == 'FEATURED') {
                    $p->label_css = 'colorLimited';
                } elseif ($p->label == 'NEW') {
                    $p->label_css = 'colorNEW';
                }
            }

            $p->status = 1;
            $p->created_at = date('Y-m-d');
            $p->save();
            $currId = $p->id;

            if ($r->same_price && !empty($r->same_price[$k])) {
            } else {
                $cur_price = $price[$k];
                $cur_min_qu = 1;
                $cur_max_qu = 1;
            }

            foreach ($cur_price as $j => $jj) {
                $p_price = new ProductPrice();
                $p_price->product_id = $currId;
                $p_price->min_quantity = 1;
                $p_price->max_quantity = 1;
                $p_price->price = $cur_price[$j];
                $p_price->save();
            }

            if ($r->same_image && !empty($r->same_image[$k])) {
            } else {
                $cur_img = $r->image[$k];
            }

            $img_count = 0;
            foreach ($cur_img as $f => $val) {
                $imgName = 'main_image_' . $currId . '_' . $f . '.' . $cur_img[$f]->getClientOriginalExtension();
                $image = Image::make($cur_img[$f]);
                $image->fit(263, 390, function ($constraint) {
                    $constraint->upsize();
                });
                Storage::disk('public_uploads')->put($imgName, (string)$image->encode());
                if ($img_count == 0) {
                    $p->main_image = $imgName;
                    $p->save();
                }


                $thum_img = 'thum_image_' . $currId . '_' . $f . '.' . $cur_img[$f]->getClientOriginalExtension();
                $image1 = Image::make($cur_img[$f]);
                $image1->resize(50, 50);
                Storage::disk('public_uploads')->put($thum_img, (string)$image1->encode());

                $main_img = 'details_main_img_' . $currId . '_' . $f . '.' . $cur_img[$f]->getClientOriginalExtension();
                $image2 = Image::make($cur_img[$f]);
                $image2->widen(480);
                Storage::disk('public_uploads')->put($main_img, (string)$image2->encode());

                $zoom_img = 'zoom_img_' . $currId . '_' . $f . '.' . $cur_img[$f]->getClientOriginalExtension();
                $image3 = Image::make($cur_img[$f]);
                $image3->widen(1024);
                Storage::disk('public_uploads')->put($zoom_img, (string)$image3->encode());

                $pi = new ProductImage();
                $pi->product_id = $currId;
                $pi->status = 1;
                $pi->p_main_image = $imgName;
                $pi->main_img = $main_img;
                $pi->color_img = $thum_img;
                $pi->thum_img = $thum_img;
                $pi->zoom_img = $zoom_img;
                $pi->created_at = date('Y-m-d');
                $pi->save();

                $img_count++;
            }
        }
        return redirect('admin/');
    }

    protected function edit_product($type, $id)
    {
        $data['product'] = Product::with('hasPrice', 'hasImage')->where('id', $id)->firstOrFail();
        if ($type == 'product') {
            $data['access'] = 1;
            return view('backend.pages.product.update', $data);
        } elseif ($type == 'accessories') {
            $data['access'] = 0;
            return view('backend.pages.product.update_access', $data);
        } else {
            return redirect('page_not_found');
        }
    }

    protected function update_product(Request $r)
    {
        //dd($r->all());
        $product = Product::find($r->p_id);
        if ($product) {
            $product->product_condition = $r->input('condition');
            $product->size = $r->input('memory');
            $product->color = $r->input('color');
            $product->quantity = $r->input('stock');
            $product->main_image = $r->input('display_pic');

            if ($r->input('product_label') == '0') {
                $product->label = '';
                $product->label_css = '';
            } else {
                $product->label = $r->input('product_label');
                if ($product->label == 'ON SALE') {
                    $product->label_css = 'colorSale';
                } elseif ($product->label == 'FEATURED') {
                    $product->label_css = 'colorLimited';
                } elseif ($product->label == 'NEW') {
                    $product->label_css = 'colorNEW';
                }
            }
            $c_name = $r->input('c_name');
            $c_description = $r->input('c_description');

            $c_dtls = null;
            foreach ($c_name[0] as $kk => $c_val) {
                if (!empty($c_name[0][$kk]) && !empty($c_description[0][$kk])) {
                    $c_dtls[$kk]['name'] = $c_name[0][$kk];
                    $c_dtls[$kk]['description'] = $c_description[0][$kk];
                }
            }

            if (isset($c_dtls) && !empty($c_dtls)) {
                $product->carrier_details = json_encode($c_dtls);
            } else {
                $product->carrier_details = null;
            }

            $product->description = $r->input('description');
            $product->save();

            ProductPrice::where('product_id', $product->id)->delete();

            $price = $r->input('price');
            $min = $r->input('min_quantity');
            $max = $r->input('max_quantity');
            foreach ($price[0] as $j => $jj) {
                $p_price = new ProductPrice();
                $p_price->product_id = $product->id;
                $p_price->min_quantity = 1;
                $p_price->max_quantity = 1;
                $p_price->price = $price[0][$j];
                $p_price->save();
            }

            return redirect('admin/product/details/' . $product->group_name . '/' . $product->is_accessories)->with('success', 'Product Updated');
        } else {
            return back()->with('error', 'Product not found');
        }
    }

    protected function change_image(Request $r)
    {
        //dd($r->all());
        $img_tbl = ProductImage::findOrFail($r->input('img_table_id'));
        $old_img = $img_tbl;
        $i1 = explode('.', $old_img->p_main_image);
        $i2 = explode('.', $old_img->main_img);
        $i3 = explode('.', $old_img->color_img);
        $i4 = explode('.', $old_img->zoom_img);

        $image = $r->image;
        $imgName = $i1[0] . '.' . $image->getClientOriginalExtension();
        $image0 = Image::make($image);
        $image0->fit(263, 390, function ($constraint) {
            $constraint->upsize();
        });
        Storage::disk('public_uploads')->put($imgName, (string)$image0->encode());

        $thum_img = $i2[0] . '.' . $image->getClientOriginalExtension();
        $image1 = Image::make($image);
        $image1->resize(50, 50);
        Storage::disk('public_uploads')->put($thum_img, (string)$image1->encode());

        $main_img = $i3[0] . '.' . $image->getClientOriginalExtension();
        $image2 = Image::make($image);
        $image2->widen(480);
        Storage::disk('public_uploads')->put($main_img, (string)$image2->encode());

        $zoom_img = $i4[0] . '.' . $image->getClientOriginalExtension();
        $image3 = Image::make($image);
        $image3->widen(1024);
        Storage::disk('public_uploads')->put($zoom_img, (string)$image3->encode());


        $img_tbl->p_main_image = $imgName;
        $img_tbl->main_img = $main_img;
        $img_tbl->color_img = $thum_img;
        $img_tbl->thum_img = $thum_img;
        $img_tbl->zoom_img = $zoom_img;
        $img_tbl->save();

        $p = Product::find($old_img->product_id);
        if ($p->main_image == $old_img->p_main_image) {
            $p->main_image = $imgName;
            $p->save();
        }

        return back()->with('success', 'Image Updated');
    }

    protected function upload_image(Request $r)
    {
        //dd($r->all());
        $id = $r->p_id;
        $count = ProductImage::where('product_id', $id)->count('id');
        $images = $r->image;
        foreach ($images as $image) {
            $imgName = 'main_image_' . $id . '_' . $count . '.' . $image->getClientOriginalExtension();
            $image0 = Image::make($image);
            $image0->fit(263, 390, function ($constraint) {
                $constraint->upsize();
            });
            Storage::disk('public_uploads')->put($imgName, (string)$image0->encode());

            $thum_img = 'thum_image_' . $id . '_' . $count . '.' . $image->getClientOriginalExtension();
            $image1 = Image::make($image);
            $image1->resize(50, 50);
            Storage::disk('public_uploads')->put($thum_img, (string)$image1->encode());

            $main_img = 'details_main_img_' . $id . '_' . $count . '.' . $image->getClientOriginalExtension();
            $image2 = Image::make($image);
            $image2->widen(480);
            Storage::disk('public_uploads')->put($main_img, (string)$image2->encode());

            $zoom_img = 'zoom_img_' . $id . '_' . $count . '.' . $image->getClientOriginalExtension();
            $image3 = Image::make($image);
            $image3->widen(1024);
            Storage::disk('public_uploads')->put($zoom_img, (string)$image3->encode());

            $pi = new ProductImage();
            $pi->product_id = $id;
            $pi->status = 1;
            $pi->p_main_image = $imgName;
            $pi->main_img = $main_img;
            $pi->color_img = $thum_img;
            $pi->thum_img = $thum_img;
            $pi->zoom_img = $zoom_img;
            $pi->created_at = date('Y-m-d');
            $pi->save();

            $count++;
        }
        return back()->with('success', 'Image Uploaded');
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
            ->with('hasPrice')
            ->where('group_name', $grp)
            ->where('status', 1)
            ->where('is_accessories', $accessories)
            ->orderBy('color')
            ->get();
        //dd($data['page_data']);
        if (sizeof($data['page_data']) == 0) {
            return back()->with('danger', 'Something went wrong. Please try Properly');
        } else {
            return view('backend.pages.product.details_list', $data);
        }
    }

    public function product_details($p_code)
    {
        $data['page_data'] = Product::with(['hasImage' => function ($q) {
            $q->where('status', 1);
        }])
            ->with('hasPrice')
            ->where('p_code', $p_code)
            ->where('status', 1)
            ->firstOrFail();
        //dd($data['page_data']);
        if ($data['page_data'] == null) {
            return back()->with('danger', 'Something went wrong. Please try Properly');
        } else {
            return view('backend.pages.product.product_details', $data);
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
        if ($tmp->count()) {
            $a = 'present';
        } else {
            $a = 'absent';
        }
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
