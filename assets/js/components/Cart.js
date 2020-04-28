import React from 'react';
import axios from 'axios';
import Paper from '@material-ui/core/Paper';
import Box from '@material-ui/core/Box';
import { withStyles } from '@material-ui/core/styles';
import Badge from '@material-ui/core/Badge';
import IconButton from '@material-ui/core/IconButton';
import Button from '@material-ui/core/Button';
import ShoppingCartIcon from '@material-ui/icons/ShoppingCart';

const StyledBadge = withStyles((theme) => ({
badge: {
    right: -3,
    top: 13,
    border: `2px solid ${theme.palette.background.paper}`,
    padding: '0 4px',
},
}))(Badge);

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

    componentDidUpdate() {
        if (this.props.items.length === 0 && this.state.showCart === true) {
            this.setState({showCart: false});
        }

        const totalItems = this.props.items.reduce((previous, current) => (
            previous + (current.quantity ? parseInt(current.quantity, 10) : 0)
        ), 0);

        if (this.state.totalItemsCount !== totalItems) {
            this.setState({totalItemsCount: totalItems});
        }
    }

    saleButtonHandler() {
        if (this.state.totalItemsCount === 0) {
            return alert('Nenhum produto adicionado!');
        }

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
        if (this.state.totalItemsCount === 0) {
            return;
        }

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
                        <button onClick={this.props.onClearCart}>Cancelar Venda</button>
                    </div>
                }
                <Paper>
                    <React.Fragment>
                        <Box display="flex" justifyContent="space-between">
                            <Box display="flex" alignItems="center">
                                <IconButton aria-label="cart" onClick={this.showCartDetails}>
                                    <StyledBadge badgeContent={this.state.totalItemsCount} color="secondary" showZero>
                                        <ShoppingCartIcon />
                                    </StyledBadge>
                                </IconButton>
                                <Box ml={1} fontWeight="fontWeightBold">
                                    {this.state.totalItemsCount === 0 ? 'Sem Produtos' : 'R$' + this.props.total}
                                </Box>
                            </Box>
                            <Box p={1.5}>
                                <Button
                                    color="secondary"
                                    variant="contained"
                                    onClick={this.saleButtonHandler}
                                >
                                    Cobrar
                                </Button>
                            </Box>
                        </Box>
                    </React.Fragment>
                </Paper>
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
