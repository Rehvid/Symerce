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

export const normalizeFiles = (input) => {
    if (Array.isArray(input)) {
        return input.filter((file) => file && file.id !== null);
    }

    if (input && typeof input === 'object' && input.id !== null) {
        return [input];
    }

    return [];
};
