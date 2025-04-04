export const prepareDataForTable = (data, additionalData = {}) => {
    return data.map((element) => {
        const processedData = { ...element, ...additionalData };

        if (typeof additionalData.actions === 'function') {
            processedData.actions = additionalData.actions(element);
        }

        return Object.values(processedData);
    });
};

export const isValidEnumValue = (enumObject, value) => {
    return Object.values(enumObject).includes(value);
};
