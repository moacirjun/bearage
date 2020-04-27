import React from 'react';
import axios from 'axios';

class Cart extends React.Component
{
    constructor(props) {
        super(props);

        this.state = {
            showCart: false,
            totalItemsCount: 0,
        };

        this.saleButtonHandler = this.saleButtonHandler.bind(this);
        this.showCartDetails = this.showCartDetails.bind(this);
    }

    componentDidUpdate(prevProps, prevState) {
        if (this.props.items.length === 0 && this.state.showCart === true) {
            this.setState({showCart: false});
        }

        const totalItems = this.props.items.reduce((previous, current) => previous + current.quantity, 0);

        if (this.state.totalItemsCount !== totalItems) {
            this.setState({totalItemsCount: totalItems});
        }
    }

    saleButtonHandler() {
        const cartItems = this.props.items;

        if (cartItems.length === 0) {
            return alert('Nenhum produto adicionado!');
        }

        const items = cartItems.map(item => ({
            id: item.code,
            quantity: item.quatity,
            discount: 0,
            unit: item.price,
            tax: 0,
            total: item.quantity * item.price,
        }));

        const payload = {
            items,
            notes: this.props.notes,
            order_discount: this.props.discount,
            order_tax: this.props.tax,
            grand_total: this.props.total,
        };

        axios.post('/api/orders', payload)
            .then(response => {
                if (response.status === 204) {
                    this.props.onCheckoutCompleted();
                    return alert('Pedido criado com sucesso!');
                }

                console.log(response.data);
            })
            .catch(e => console.error(e));
    }

    showCartDetails() {
        this.setState({showCart: !this.state.showCart});
    }

    render() {
        return (
            <div>
                {this.state.showCart &&
                    <div>
                        <label>Desconto: </label>
                        <input
                            name="discount"
                            type="number"
                            value={this.props.discount}
                            onChange={(event) => this.props.onCartDetailsChange(event.target.name, event.target.value)}
                        /><br/>
                        <label>Taxas: </label>
                        <input
                            name="tax"
                            type="number"
                            value={this.props.tax}
                            onChange={(event) => this.props.onCartDetailsChange(event.target.name, event.target.value)}
                        /><br/>
                        <label>Observaçãpreviouso: </label>
                        <input
                            name="notes"
                            type="text"
                            value={this.props.notes}
                            onChange={(event) => this.props.onCartDetailsChange(event.target.name, event.target.value)}
                        /><br/>
                        <label>Items: </label>
                        <ul>
                            {this.props.items.map(item => (
                                <li key={item.code}>
                                    {item.name}
                                    {' - '}
                                    <input
                                        type="number"
                                        onChange={(event) => this.props.onItemQuantityChange(item, event.target.value)}
                                        value={item.quantity}
                                    />
                                    <button type="button" onClick={() => this.props.onItemRemoved(item)}>Remover</button>
                                </li>
                            ))}
                        </ul>
                    </div>
                }
                <label>Produtos: {this.state.totalItemsCount}</label>
                <label>Total: {this.props.total}</label>
                <button onClick={this.saleButtonHandler}>Vender</button>
                {
                    this.props.items.length === 0 ||
                    <label>
                        <button onClick={this.showCartDetails}>Ver Carrinho</button>
                        <button onClick={this.props.onClearCart}>Cancelar Venda</button>
                    </label>
                }
            </div>
        );
    }
}

Cart.defaultProps = {
    items: [],
    discount: 0,
    tax: 0,
    total: 0,
    notes: '',
    onCheckoutCompleted: () => {},
    onCartDetailsChange: (name, value) => {},
};

export default Cart;
