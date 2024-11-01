module.exports = {
    isContainerSup: () => {
        return CSS && CSS.hasOwnProperty('supports') && CSS.supports('container-type', 'inline-size');
    },
}
