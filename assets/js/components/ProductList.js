import React from 'react';
import { makeStyles } from '@material-ui/core/styles';
import {
    List,
    ListItemAvatar,
    Avatar,
    ListItem,
    ListItemText,
    Box,
    Typography,
    Divider
} from '@material-ui/core';
import ImageIcon from '@material-ui/icons/Image';

const useStyles = makeStyles(theme => ({
    root: {
        width: '100%',
        backgroundColor: theme.palette.background.paper,
    },
    listText: {
        display: 'flex',
        justifyContent: 'space-between',
    },
    bold: {
        fontWeight: 'bold',
    },
}));

const ProductList = (props) => {
    const classes = useStyles();

    const renderItem = (item) => (
        <React.Fragment>
            <ListItem key={item.code} button onClick={() => props.onProductClick(item)}>
                <ListItemAvatar>
                    <Avatar>
                        <ImageIcon />
                    </Avatar>
                </ListItemAvatar>
                <ListItemText>
                    <Box className={classes.listText}>
                        <Typography variant="body2" className={classes.bold}>{item.name}</Typography>
                        <Typography variant="body2" className={classes.bold}>R${item.price}</Typography>
                    </Box>
                </ListItemText>
            </ListItem>
            <Divider variant="inset" component="li" />
        </React.Fragment>
    );

    return (
        props.isFetching
            ? <h4>Procurando...</h4>
            : <List className={classes.root}>
                {props.products.map(item => (renderItem(item)))}
            </List>
    );
};

export default ProductList;
