import React from 'react';
import ProductSearch from './ProductSearch';
import ProductList from './ProductList';

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
            order: {
                items: [],
                discount: 0,
                tax: 0,
                notes: '',
                total: 0,
            }
        };

        this.setIsFetching = this.setIsFetching.bind(this);
        this.onSearchTextChange = this.onSearchTextChange.bind(this);
        this.setItems = this.setItems.bind(this);
        this.onProductClick = this.onProductClick.bind(this);
        this.addProductToOrder = this.addProductToOrder.bind(this);
        this.recalculateOrderTotal = this.recalculateOrderTotal.bind(this);
    }

    componentDidMount() {
        this.setState(state => ({search: 'a'}));
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
        const orderItem = {
            code: product.code,
            quatity: 1,
            price: product.salePrice,
        };

        const items = this.state.order.items.concat(orderItem);

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
            return previous + current.price;
        }, 0);

        const total = totalItems + tax - discount;

        this.setState((state) => ({
            order: {
                ...state.order,
                total
            },
        }));
    }

    render() {
        return (
            <React.Fragment>
                <h2>Home</h2>
                <h3>Detalhes da venda</h3>
                <div>
                    <label>Desconto: <input type="number" value={this.state.order.discount}/></label><br/>
                    <label>Taxas: <input type="number" value={this.state.order.tax}/></label><br/>
                    <label>Notas: <input type="text" value={this.state.order.notes}/></label><br/>
                    <label>Total: {this.state.order.total}</label><br/>
                    {this.state.order.items.length === 0 || <button onClick={this.saleButtomHandler}>Vender</button>}
                </div>
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
