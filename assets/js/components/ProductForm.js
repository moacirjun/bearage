import React from 'react';

const ProductForm = (props) => (
    <form>
        <input
            type="text"
            name="code"
            placeholder="code"
            onChange={(event) => props.handleChange(event.target.name, event.target.value)}
            value={props.product.code}
        /><br/>
        <input
            type="text"
            name="name"
            placeholder="name"
            onChange={(event) => props.handleChange(event.target.name, event.target.value)}
            value={props.product.name}
        /><br/>
        <input
            type="text"
            name="description"
            placeholder="Description"
            onChange={(event) => props.handleChange(event.target.name, event.target.value)}
            value={props.product.description}
        /><br/>
        <input
            type="text"
            name="price"
            placeholder="price"
            onChange={(event) => props.handleChange(event.target.name, event.target.value)}
            value={props.product.price}
        /><br/>
        <input
            type="text"
            name="salePrice"
            placeholder="sale price"
            onChange={(event) => props.handleChange(event.target.name, event.target.value)}
            value={props.product.salePrice}
        /><br/>
        <input
            type="text"
            name="cost"
            placeholder="cost"
            onChange={(event) => props.handleChange(event.target.name, event.target.value)}
            value={props.product.cost}
        /><br/>
        <input
            type="number"
            name="stock"
            placeholder="stock"
            onChange={(event) => props.handleChange(event.target.name, event.target.value)}
            value={props.product.stock}
        /><br/>

        {props.handleSubmit &&
            <button type="button" onClick={props.handleSubmit}>
                {props.submitLabel || 'Criar'}
            </button>
        }
    </form>
);

export default ProductForm;
