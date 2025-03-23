export const prepareDataForTable = (data, additionalData = {}) => {
    return data.map(element => {
        return Object.values({
            ...element,
            ...additionalData,
        });
    });
};
