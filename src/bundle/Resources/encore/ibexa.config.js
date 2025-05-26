const path = require('path');

module.exports = (Encore) => {
    Encore.addEntry('ibexa-system-information-css', [path.resolve(__dirname, '../public/scss/system-information.scss')]);
};
