import React from 'react';
import ProductSearch from './ProductSearch';
import ProductList from './ProductList';
import Cart from './Cart';

class Home extends React.Component
{
    constructor() {
        super();

        this.state = {
            search: '',
            products: {
                isFetching: false,
                items: [],
            },
            order: this.getBlankOrder()
        };

        this.setIsFetching = this.setIsFetching.bind(this);
        this.onSearchTextChange = this.onSearchTextChange.bind(this);
        this.setItems = this.setItems.bind(this);
        this.onProductClick = this.onProductClick.bind(this);
        this.addProductToOrder = this.addProductToOrder.bind(this);
        this.recalculateOrderTotal = this.recalculateOrderTotal.bind(this);
        this.clearCart = this.clearCart.bind(this);
        this.updateCartDetails = this.updateCartDetails.bind(this);
        this.changeOrderItemQuantity = this.changeOrderItemQuantity.bind(this);
        this.removeOrderItem = this.removeOrderItem.bind(this);
    }

    componentDidUpdate() {
        if (
            this.state.order.items.length === 0 &&
            (
                this.state.order.discount !== 0
                || this.state.order.tax !== 0
                || this.state.order.total !== 0
                || this.state.order.notes !== ''
            )
        ) {
            this.setState({order: this.getBlankOrder()});
        }
    }

    setIsFetching(fetcing) {
        this.setState(state => ({
            products: {...state.products, isFetching: fetcing}
        }));
    }

    onSearchTextChange(text) {
        this.setState({ search: text });
    }

    setItems(items) {
        this.setState({
            products: {
                ...this.state.products,
                items
            }
        });
    }

    onProductClick(product) {
        this.addProductToOrder(product);
    }

    addProductToOrder(product) {
        let items = this.state.order.items.concat();

        const itemIndexOnCart = items.findIndex(item => (item.code === product.code));

        if (itemIndexOnCart === -1) {
            items.push({
                name: product.name,
                code: product.code,
                quantity: 1,
                price: product.salePrice,
            });
        } else {
            items[itemIndexOnCart].quantity += 1;
        }

        this.setState((state) => ({
            order: {
                ...state.order,
                items
            },
        }), () => this.recalculateOrderTotal());
    }

    recalculateOrderTotal() {
        const {items, discount, tax} = this.state.order;

        const totalItems = items.reduce((previous, current) => {
            return previous + (current.price * current.quantity);
        }, 0);

        const intDiscount = discount ? parseInt(discount) : 0,
            intTax = tax ? parseInt(tax) : 0;

        const total = totalItems + intTax - intDiscount;

        this.setState((state) => ({
            order: {
                ...state.order,
                total
            },
        }));
    }

    clearCart() {
        this.setState({
            order: this.getBlankOrder(),
        });
    }

    getBlankOrder() {
        return {
            items: [],
            discount: 0,
            tax: 0,
            notes: '',
            total: 0,
        };
    }

    updateCartDetails(name, value) {
        this.setState(state => ({
            order: {
                ...state.order,
                [name]: value
            }
        }), () => this.recalculateOrderTotal());
    }

    changeOrderItemQuantity(item, quantity) {
        const {code} = item;

        const orderItems = this.state.order.items.concat();
        const IndexOnOrder = orderItems.findIndex(orderItem => {
            return orderItem.code === code;
        });

        if (IndexOnOrder === -1) {
            return;
        }

        orderItems[IndexOnOrder].quantity = quantity;

        this.setState(state => ({
            order: {
                ...state.order,
                items: orderItems
            }
        }), () => this.recalculateOrderTotal());
    }

    removeOrderItem({ code }) {
        let orderItems = this.state.order.items.concat();

        const indexOnOrder = orderItems.findIndex(orderItem => {
            return orderItem.code === code;
        });

        if (indexOnOrder === -1) {
            return;
        }

        orderItems.splice(indexOnOrder, 1);

        this.setState(state => ({
            order: {
                ...state.order,
                items: orderItems
            }
        }), () => this.recalculateOrderTotal());
    }
    render() {
        return (
            <React.Fragment>
                <h2>Home</h2>
                <h3>Detalhes da venda</h3>
                <Cart
                    items={this.state.order.items}
                    discount={this.state.order.discount}
                    tax={this.state.order.tax}
                    total={this.state.order.total}
                    notes={this.state.order.notes}
                    onCheckoutCompleted={this.clearCart}
                    onCartDetailsChange={this.updateCartDetails}
                    onItemQuantityChange={this.changeOrderItemQuantity}
                    onItemRemoved={this.removeOrderItem}
                    onClearCart={this.clearCart}
                />
                <hr/>
                <h3>Pesquisar</h3>
                <ProductSearch
                    isFetching={this.setIsFetching}
                    onSearchTextChange={this.onSearchTextChange}
                    setItems={this.setItems}
                    searchText={this.state.search}
                />
                <hr/>
                <h3>Produtos</h3>
                <ProductList
                    isFetching={this.state.products.isFetching}
                    products={this.state.products.items}
                    onProductClick={this.onProductClick}
                />
            </React.Fragment>
        );
    }
}

export default Home;
