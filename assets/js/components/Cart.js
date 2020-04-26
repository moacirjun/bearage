import React from 'react';
import axios from 'axios';

class Cart extends React.Component
{
    constructor(props) {
        super(props);

        this.saleButtonHandler = this.saleButtonHandler.bind(this);
        this.showCartDetails = this.showCartDetails.bind(this);
    }

    saleButtonHandler() {
        const items = this.props.items.map(item => ({
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
            order_discount: 0,
            order_tax: 0,
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

    }

    render() {
        return (
            <div>
                <label>Total: {this.props.total}</label>
                {
                    this.props.items.length === 0 ||
                    <label>
                        <button onClick={this.saleButtonHandler}>Vender</button>
                        <button onClick={this.showCart}>Ver Carrinho</button>
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
};

export default Cart;