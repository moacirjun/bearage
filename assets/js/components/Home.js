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
                code: product.code + '-1', //Transform product code to productVariant code
                quatity: 1,
                price: product.salePrice,
            });
        } else {
            items[itemIndexOnCart].quatity += 1;
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
            return previous + (current.price * current.quatity);
        }, 0);

        const total = totalItems + tax - discount;

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
