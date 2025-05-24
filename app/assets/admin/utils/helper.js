export const prepareDraggableDataToUpdateOrder = (data) => {
    const { movedId = null, oldPosition = null, newPosition = null } = data;

    return {
        movedId,
        oldPosition,
        newPosition,
    };
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
    const assignUuid = (file) => ({
        ...file,
        uuid: file.uuid ?? crypto.randomUUID(),
    });

    if (Array.isArray(input)) {
        return input.filter((file) => file && file.id !== null).map(assignUuid);
    }

    if (input && typeof input === 'object' && input.id !== null) {
        return [assignUuid(input)];
    }

    return [];
};

export const filterEmptyValues = (filters) => {
    const cleaned = {};

    for (const key in filters) {
        const value = filters[key];
        if (value !== null && value !== undefined) {
            cleaned[key] = value;
        }
    }

    return cleaned;
};

export const isOnlyPaginationInDataTable = (filters) => {
    if (!filters) {
        return true;
    }
    const allowedKeys = ['page', 'limit'];
    return Object.keys(filters).every((key) => allowedKeys.includes(key));
};
