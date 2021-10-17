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
    if (cartArr.length > 0) {
        cartArr.forEach(element => {
            txt += ` <li>
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
        });
    }
    document.querySelector('#total_price_top').innerHTML = totalPrice;
    document.querySelector('#cart_items_short').innerHTML = txt;
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
renderCartItem();
updateQuantity();