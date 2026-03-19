<script>
export default{
    props: {
        how: {
            type: Function,
        },
    },
    render(){
        return this.how()
    }
}
</script>
