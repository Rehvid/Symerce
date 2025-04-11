export const prepareDataForTable = (data, additionalData = {}) => {
    return data.map((element) => {
        const processedData = { ...element, ...additionalData };

        if (typeof additionalData.actions === 'function') {
            processedData.actions = additionalData.actions(element);
        }

        return Object.values(processedData);
    });
};

export const prepareDraggableDataToUpdateOrder = (data) => {
    let draggableData = [];
    data.forEach((element, key) => {
        draggableData = [...draggableData, element[0]];
    });
    return { order: draggableData };
};

export const isValidEnumValue = (enumObject, value) => {
    return Object.values(enumObject).includes(value);
};
