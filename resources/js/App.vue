<template>
    <div id="app">
        <Header />
        <Home />
        <Footer />
    </div>
</template>

<script>
    import Header from './components/layouts/Header';
    import Footer from './components/layouts/Footer';
    import Home from './views/Home';

    export default {
        name: "app",
        components: {
            Header,
            Footer,
            Home
        }
    }
</script>


<style>

</style>