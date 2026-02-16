Object.get = (object, key) => {
    return key.split('.').reduce(function(object, currentKey) {
        return object[currentKey]
    }, object);
}
