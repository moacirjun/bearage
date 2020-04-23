import React, { Component } from 'react';

class Products extends Component
{
    constructor() {
        super();
        this.state = {
            products: {
                isFetcing: false,
                items: []
            }
        };
    }

    componentDidMount() {
        this.fetchProducts();
    }

    fetchProducts() {
        this.setState({products: {...this.state.products, isFetcing: true}});

        console.axios.get('api/products')
            .then(response => {
                this.setState({products: {...this.state.products, isFetcing: false}});

                if (response.status !== 200) {
                    return;
                }

                const { data: { items } } = response;

                this.setState({products: {...this.state.products, items}});
            })
            .catch(error => console.error(error));
    }

    render() {
        const { isFetcing, items } = this.state.products;

        return (
            <div>
                <h1>Produtos</h1>
                {isFetcing ? <h3>Loading...</h3> : items.map(product => (
                    <div key={product.code}>
                        <h3>{product.name}</h3>
                        <ul>
                            <li>Code: {product.code}</li>
                            <li>Estoque: {product.stock}</li>
                            <li>Preço: {product.price}</li>
                            <li>Preço de Venda: {product.saleProce}</li>
                            <li>Custo: {product.cost}</li>
                        </ul>
                    </div>
                ))}
            </div>
        );
    }
}

export default Products;
