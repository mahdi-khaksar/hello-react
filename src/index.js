import domReady from '@wordpress/dom-ready';
import { createRoot } from '@wordpress/element';

const HelloReactPage = () => {
    return <h1>Hello React</h1>;
};

domReady( () => {
    const root = createRoot(
        document.getElementById( 'root' )
    );
    root.render( <HelloReactPage /> );
} );
