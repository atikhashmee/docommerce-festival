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
    this.quantity = 1;
    this.image = product.original_product_img || null;
    this.store_id =  product.store_id || null;
    this.admin_id =  product.admin_id || null;
    this.original_store_id =  product.original_store_id || null;
    this.original_product_id = product.original_product_id || null;
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
                if (Number(element.id) === Number(item.id)) {
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
    let totalPrice = cartArr.length > 0 ? cartArr.reduce((t, c)=> t+(Number(c.price) * Number(c.quantity)), 0) : 0;
    let cartListPage = '';
    let checkoutPage = '';
    if (cartArr.length > 0) {
        cartArr.forEach(element => {
        txt += `<li>
                <div class="shopping-cart-img">
                    <a href="#"><img alt="product" src="${element.image}"></a>
                </div>
                <div class="shopping-cart-title">
                    <h4><a href="shop-product-right.html">${element.name}</a></h4>
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
                    <p class="product_name">${element.name}</p>
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
                    <p class="product_name">${element.name}</p>
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
    if (checkout_page_lists) {
        checkout_page_lists.innerHTML = checkoutPage;
    }
    if (cartPageView) {
        cartPageView.innerHTML = cartListPage;
    }
    if (cart_sub_total_page) {
        cart_sub_total_page.innerHTML = totalPrice;
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
                txt += `<option value="${item.id}">${item.name}</option>`
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

renderCartItem();
updateQuantity();

