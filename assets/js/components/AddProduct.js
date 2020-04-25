import React, { Component } from 'react';
import axios from 'axios';
import ProductFrom from './ProductForm';

class AddProduct extends Component
{
    constructor() {
        super();

        this.state = {
            product: {
                code: '',
                name: '',
                description: '',
                price: '',
                salePrice: '',
                cost: '',
                stock: '',
            }
        };

        this.handleChange = this.handleChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    handleChange(name, value) {
        this.setState({
            product: {
                ...this.state.product,
                [name]: value
            }
        });
    };

    handleSubmit(event) {
        const payload = { ...this.state.product, sale_price: this.state.product.salePrice };

        axios.post('/api/products', payload)
            .then(response => {
                if (response.status === 201) {
                    return alert('Produto criado com sucesso!');
                }

                alert(response.message || 'Deu ruim');
            })
            .catch(e => console.error(e));

        event.preventDefault();
    }

    render() {
        return (
            <ProductFrom
                product={this.state.product}
                handleChange={this.handleChange}
                handleSubmit={this.handleSubmit}
                submitLabel="Criar"
            />
        );
    }
}

export default AddProduct;
