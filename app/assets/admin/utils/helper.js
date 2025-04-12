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

export const convertFileToBase64 = (file) => {
    return new Promise((resolve, reject) => {
        if (file instanceof Blob) {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => resolve(reader.result);
            reader.onerror = (error) => reject(error);
        }
    });
};

export const isValidEnumValue = (enumObject, value) => {
    return Object.values(enumObject).includes(value);
};
