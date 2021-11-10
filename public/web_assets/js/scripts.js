const PER_KG_WEIGHT = 20
const SHIPPING_CHARGE_PER_STORE = 60

class StorageData{
    putData(data, name=null) {
        let keyName = name===null? 'cartItems':name;
        localStorage.setItem(keyName, JSON.stringify(data));
    }
    getData(name=null) {
        let keyName = name===null? 'cartItems':name;
        let allData = localStorage.getItem(keyName);
        if (!allData) {
            return [];
        }
        return JSON.parse(allData);
    }
    removeLocalData(name) {
        localStorage.removeItem(name);
    }
}

function CartItem(product) {
    this.id =  product.id || null;
    this.slug = product.slug || null;
    this.name = product.name ||  null;
    this.price = product.price || 0;
    this.weight = product.weight || 0.0;
    this.selected_variant = product.selected_variant || null;
    this.quantity = product.quantity || 1;
    this.image = product.original_product_img || null;
    this.store_id =  product.store_id || null;
    this.admin_id =  product.admin_id || null;
    this.original_store_id =  product.original_store_id || null;
    this.original_product_id = product.original_product_id || null;
    if (this.selected_variant !== null) {
        this.weight =  product.selected_variant.weight;
    }
}

CartItem.prototype.totalPrice = function() {
    return this.price * this.quantity;
}

let storage = new StorageData();

function addToCart(product) {
    let cartArr = storage.getData();
    let item  = new CartItem(product);
    if (item.id !== null) {
        if (cartArr.length === 0) {
            cartArr.push(item);
        } else {
            let alreadyThere = false;
            cartArr = cartArr.map(element=>{
                if (element.id == item.id) {
                    element.quantity = element.quantity + 1
                    alreadyThere = true;
                }
                return element;
            })
            if (!alreadyThere) {
                cartArr.push(item);
            }
        }
    }
    flashMessage('success', item.name)
    storage.putData(cartArr);
    updateQuantity();
    renderCartItem();
}

function updateQuantity() {
    let cartArr = storage.getData();
    document.querySelector('#cart_quantity').innerHTML = cartArr.length;
}

function renderCartItem() {
    let cartArr = storage.getData();
    let txt = '';
    let stores = [];
    let subTotalPrice = cartArr.length > 0 ? cartArr.reduce((t, c)=> {
        let additional_price = 0;
        if (Number(c.weight) > 0) {
            additional_price = Math.ceil(c.weight) * PER_KG_WEIGHT
        }
        stores[c.original_store_id] = SHIPPING_CHARGE_PER_STORE
        return t+((Number(c.price) + Number(additional_price)) * Number(c.quantity))
    }, 0) : 0;
    let shippingCharge = stores.length > 0 ?  stores.reduce((t,c)=>t+c, 0)  : 0
    let totalPrice = subTotalPrice;
    if (shippingCharge > 0) {
        totalPrice += shippingCharge
    }
    let cartListPage = '';
    let checkoutPage = '';
    if (cartArr.length > 0) {
        cartArr.forEach(element => {
        let option1 = "" 
        let option2 = "" 
        let option3 = "" 
        let weight = "" 
        let weightFee = "" 
        //variant specifies start
        if (element.selected_variant !== null) {
            if (element.selected_variant.opt1_name !== null) {
                option1 = "("+element.selected_variant.opt1_name+" : "+element.selected_variant.opt1_value+")"
            }
        }
        if (element.selected_variant !== null) {
            if (element.selected_variant.opt2_name !== null) {
                option2 = "("+element.selected_variant.opt2_name+" : "+element.selected_variant.opt2_value+")"
            }
        }
        if (element.selected_variant !== null) {
            if (element.selected_variant.opt3_name !== null) {
                option3 = "("+element.selected_variant.opt3_name+" : "+element.selected_variant.opt3_value+")"
            }
        }
        //variant specifies end

        //weight calculation start
        if (Number(element.weight) > 0) {
            weight = "<strong>("+element.weight+"kg)</strong>"
            weightFee = "(Weight Fee: <strong>৳"+(element.quantity * Math.ceil(element.weight) * PER_KG_WEIGHT)+"</strong>)"
        }
        //weight calculation end


        txt += `<li>
                <div class="shopping-cart-img">
                    <a href="#"><img alt="product" src="${element.image}"></a>
                </div>
                <div class="shopping-cart-title">
                    <h4><a href="shop-product-right.html">${element.name} ${option1} ${option2} ${option3}</a></h4>
                    <h4><span>${element.quantity} × </span>৳${element.price}</h4>
                </div>
                <div class="shopping-cart-delete">
                    <a href="javascript:void(0)" data-id="${element.id}" onclick="removeCartItem(this)"><i class="fa fa-times"></i></a>
                </div>
        </li>`;

        cartListPage += `<tr>
                <td>
                    <img src="${element.image}" alt="${element.name}" class="cart-product-img">
                </td>
                <td>
                    <p class="product_name">${element.name} ${option1} ${option2} ${option3} ${weight}</p>
                </td>
                <td>
                    <p class="product_price">৳${element.price}</p>
                </td>
                <td>
                    <div class="input-group plus-minus-input w-150">
                        <div class="input-group-button">
                            <button type="button" class="button hollow circle" data-id="${element.id}" onclick="decreaseQuantity(this)">
                                <i class="fa fa-minus" aria-hidden="true"></i>
                            </button>
                        </div>
                        <input class="input-group-field" type="number" name="quantity" value="${Number(element.quantity)}">
                        <div class="input-group-button">
                            <button type="button" class="button hollow circle" data-id="${element.id}" onclick="increaseQuantity(this)">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </button>
                        </div>

                    </div> 
                </td>
                <td>
                    <p class="product_price">৳${Number(element.price) * Number(element.quantity)}</p>
                </td>
                <td>
                    <button class="btn btn-danger"  data-id="${element.id}" onclick="removeCartItem(this)">
                        <i class="fa fa-times"></i> Remove
                    </button>
                </td>
        </tr>`;

        checkoutPage += `<tr>
                <td>
                    <img src="${element.image}" alt="${element.name}" class="checkout-product-img">
                </td>
                <td>
                    <p class="product_name">${element.name} ${option1} ${option2} ${option3} ${weight}</p>
                    <p>${weightFee}</p>
                </td>
                <td>
                    <p class="product_price">৳${element.price}</p>
                </td>
                <td>
                    <p>
                        <span>${element.quantity}</span>
                    </p> 
                </td>
                <td>
                    <p>
                        ---
                    </p> 
                </td>
                <td>
                    <p class="product_price">৳${Number(element.price) *  Number(element.quantity)}</p>
                </td>
                
        </tr>`;
        });
    }
    document.querySelector('#total_price_top').innerHTML = totalPrice;
    document.querySelector('#cart_items_short').innerHTML = txt;

    let cartPageView = document.querySelector('#cart_list_page');
    let cart_sub_total_page = document.querySelector('#cart_sub_total_page');
    let cart_total_page = document.querySelector('#cart_total_page');
    let checkout_page_lists = document.querySelector('#checkout_page_lists');
    let cart_shipping_page = document.querySelector('#cart_shipping_page');

    if (cart_shipping_page) {
        cart_shipping_page.innerHTML = shippingCharge;
    }

    if (checkout_page_lists) {
        checkout_page_lists.innerHTML = checkoutPage;
    }
    if (cartPageView) {
        cartPageView.innerHTML = cartListPage;
    }
    if (cart_sub_total_page) {
        cart_sub_total_page.innerHTML = subTotalPrice;
    }
    if (cart_total_page) {
        cart_total_page.innerHTML = totalPrice;
    }
}

function removeCartItem(elem) {
    let id = $(elem).data('id')
    let cartArr = storage.getData();
    let obj = cartArr.find(element=>element.id == id);
    if (obj) {
        cartArr.splice(cartArr.indexOf(obj), 1);
    }
    storage.putData(cartArr);
    updateQuantity();
    renderCartItem();
}

function increaseQuantity(elem) {
    let id = $(elem).data('id')
    let cartArr = storage.getData();
    if (cartArr.length > 0) {
        cartArr = cartArr.map(element => {
            if (Number(element.id) === Number(id)) {
                element.quantity = element.quantity + 1
            }
            return element;
        })
    }
    storage.putData(cartArr);
    renderCartItem();
}

function decreaseQuantity(elem) {
    let id = $(elem).data('id')
    let cartArr = storage.getData();
    if (cartArr.length > 0) {
        cartArr = cartArr.map(element => {
            if (Number(element.id) === Number(id)) {
                if (!(element.quantity <= 1)) {
                    element.quantity = element.quantity - 1
                }
            }
            return element;
        })
    }
    storage.putData(cartArr);
    renderCartItem();
}

function getDistrict(dists) {
    let districts = dists;
    let state_id = document.querySelector('#state_id').value;
    let state_districts = districts.filter(item=>Number(item.global_state_id) === Number(state_id))
    let districtDom = document.querySelector('#district_id');
    let txt = `<option value="">Select a District</option>`;
    if (districtDom) {
        if (state_districts.length > 0) {
            state_districts.forEach(item => {
                if (item.id == 47) {
                    txt += `<option value="${item.id}" selected>${item.name}</option>`
                } else {
                    txt += `<option value="${item.id}" disabled>${item.name}</option>`
                }
            })
        }
        districtDom.innerHTML = txt;
    }
}

function createTag(tagN, msg) {
    let tag = document.createElement(tagN);
    tag.className="text-danger generated_error_tag";
    tag.innerHTML = msg;
    return tag;
}

function validationErrors(errors) { 
    //remove all element
    let elems = document.querySelectorAll('.generated_error_tag')
    if (elems.length > 0) {
        for (let index = 0; index < elems.length; index++) {
            const element = elems[index];
            element.remove();
        } 
    }
    
    for (const key in errors) {
        let domEl = document.querySelector(`input[name="${key}"]`) || document.querySelector(`select[name="${key}"]`);
        if (domEl) {
            let upperDom = domEl.closest('div');
            if (upperDom) {
                upperDom.append(createTag('span', errors[key][0]))
            }
        }
    }
}


function placeOrder() {
    let formD = new FormData(document.querySelector('#checkout_form'))
    formD.append('items', JSON.stringify(storage.getData()))
    formD.append('cart_shipping_page', document.querySelector('#cart_shipping_page').innerHTML)
    fetch(baseUrl+'/place_order', {
        method: 'POST',
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formD
    }).then(res=>res.json())
    .then(res=>{
        if (res.status) {
            let successDom = document.querySelector('#success_msg');
            successDom.classList.remove('d-none');
            successDom.innerHTML = res.success
            setTimeout(() => {
                storage.putData([]);
                updateQuantity();
                renderCartItem();
                window.location.href = baseUrl+'/order-completed/'+res.data;
            }, 1000);
            
        } else {
            if ('errors' in res) {
                validationErrors(res.errors)
            } else {
                let errorDom = document.querySelector('#error_msg');
                errorDom.classList.remove('d-none');
                errorDom.innerHTML = res.error
            }
        }
    })
}

var allVarinats = [];
var selectedVariant = {};

function updatePrice() {
    let options = [];
    $('.each-variant-row .active').each(function() { 
        options.push($(this).data('item'));
    });
    allVarinats.forEach(item=> {
        let itemSelected = [];
        if (typeof options[0]!=='undefined') {
            if (item.opt1_value !== null) {
                if (options[0] === item.opt1_value) {
                    itemSelected.push(1);
                }
            }
        }

        if (typeof options[1]!=='undefined') {
            if (item.opt2_value !== null) {
                if (options[1] === item.opt2_value) {
                    itemSelected.push(1);
                }
            }
        }

        if (typeof options[2]!=='undefined') {
            if (item.opt3_value !== null) {
                if (options[2] === item.opt3_value) {
                    itemSelected.push(1);
                }
            }
        }
        if (options.length === itemSelected.length) {
            document.querySelector('#product_price').innerHTML = item.price;
            document.querySelector('#product_old_price').innerHTML = item.old_price;
            var vaData = document.querySelector('#variants_data');
            if (vaData) {
                vaData = JSON.parse(vaData.value);
                let selectedVariantData = vaData.find(ite => ite.id == item.id);
                document.querySelector('#selected_variant').value = JSON.stringify(selectedVariantData)
            }
        }
    })
}

function fillVariantData(vaData) {
    if (vaData.length > 0) {
        vaData.forEach(item=>{
            let names = item.name.split('/');
            let obj = {}
            obj.opt1_value = typeof names[0] !== 'undefined' ? item.opt1_value: null 
            obj.opt2_value = typeof names[1] !== 'undefined' ? item.opt2_value: null 
            obj.opt3_value = typeof names[2] !== 'undefined' ? item.opt3_value: null 
            obj.old_price = item.old_price
            obj.price = item.price
            obj.id = item.id
            allVarinats.push(obj)
        })
    }
}

function variantInit() {
    let selectVarDom = document.querySelector('#selected_variant');
    selectedVariant = JSON.parse(selectVarDom ? selectVarDom.value : '[]');
    var vaData = document.querySelector('#variants_data');
    if (vaData) {
        vaData = JSON.parse(vaData.value);
        fillVariantData(vaData);
    }

    //initial Active 
    let allrows = document.querySelectorAll('.each-variant-row');
    if (allrows.length > 0) {
        for (let index = 0; index < allrows.length; index++) {
            const parent = allrows[index];
            let allbuttons = parent.querySelectorAll('button');
            if (allbuttons.length > 0) {
                for (let jindex = 0; jindex < allbuttons.length; jindex++) {
                    const button = allbuttons[jindex];
                    let value = button.getAttribute('data-item');
                    if (selectedVariant.opt1_value === value || selectedVariant.opt2_value === value || selectedVariant.opt3_value === value) {
                        button.classList.add('active')
                    }
                }
            }
        }
    }
}
function changeVariant(dom) {
    let rowVar = dom.closest('.each-variant-row');
    let varItems = rowVar.querySelectorAll('button');
    if (varItems.length > 0) {
        for (let index = 0; index < varItems.length; index++) {
            const element = varItems[index];
            element.classList.remove('active');
        }
    }
    dom.classList.add('active');
    updatePrice();
}

function variantProductAdd(product) {
    let selected_variant = document.getElementById('selected_variant')
    let product_quantity = document.getElementById('product_quantity')
    let flag = true;
    if ('raw_variants' in product) {
        if (product.raw_variants.length> 0 && (selected_variant === null && (selected_variant.value ==="" || selected_variant.value === null))) {
            errorLists.appendChild(createError('you have to select a variant'))
            flag = false
        }
    }

    if (!flag) return
    let se_var = JSON.parse(document.querySelector('#selected_variant').value);
    if (se_var!==null) {
        product.selected_variant = se_var
        product.id = product.id+"_"+se_var.id
    }
    product.quantity = product_quantity.value;
    addToCart(product)
}

renderCartItem();
updateQuantity();
variantInit();


$('.p-d-switch').click(function () {
    fetch(baseUrl+'/quick-view/'+$(this).data('product_id'))
    .then(res=>res.text())
    .then(res=>{
      $("#productDetailsModal .modal-body").html(res);
      $('#productDetailsModal').modal('show');
      $("#zoom_01").ezPlus({
        containLensZoom: true, gallery: 'gallery_01', cursor: 'pointer', galleryActiveClass: 'active'
      });

      // addPriceCart

      $('[data-quantity="plus"]').click(function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('data-field');
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        // If is not undefined
        if (!isNaN(currentVal)) {
            // Increment
            $('input[name='+fieldName+']').val(currentVal + 1);
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
        }
    });
    // This button will decrement the value till 0
    $('[data-quantity="minus"]').click(function(e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('data-field');
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        // If it isn't undefined or its greater than 0
        if (!isNaN(currentVal) && currentVal > 1) {
            // Decrement one
            $('input[name='+fieldName+']').val(currentVal - 1);
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(1);
        }
    });
        variantInit();
    })
  });
