import { DraggableItem } from '@admin/common/types/draggableItem';

export interface DraggableData {
    movedId: string | null;
    oldPosition: number | null;
    newPosition: number | null;
}

export const prepareDraggableDataToUpdateOrder = (
    data: DraggableItem
): DraggableItem => {
    const { movedId = null, oldPosition = null, newPosition = null } = data;

    return {
        movedId,
        oldPosition,
        newPosition,
    };
};

export const convertFileToBase64 = (file: Blob): Promise<string | ArrayBuffer | null> => {
    return new Promise((resolve, reject) => {
        if (file instanceof Blob) {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => resolve(reader.result);
            reader.onerror = (error) => reject(error);
        } else {
            reject(new Error('Provided file is not a Blob'));
        }
    });
};

export const isValidEnumValue = <T extends object>(enumObject: T, value: unknown): value is T[keyof T] => {
    return Object.values(enumObject).includes(value as T[keyof T]);
};

interface FileWithId {
    id: string | null;
    uuid?: string;
    [key: string]: any;
}

export const normalizeFiles = (input: FileWithId | FileWithId[] | null | undefined): FileWithId[] => {
    const assignUuid = (file: FileWithId): FileWithId => ({
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

export const filterEmptyValues = <T extends Record<string, any>>(filters: T): Partial<T> => {
    const cleaned: Partial<T> = {};

    for (const key in filters) {
        const value = filters[key];
        if (value !== null && value !== undefined) {
            cleaned[key] = value;
        }
    }

    return cleaned;
};

export const isOnlyPaginationInDataTable = (filters?: Record<string, any>): boolean => {
    if (!filters) {
        return true;
    }
    const allowedKeys = ['page', 'limit'];
    return Object.keys(filters).every((key) => allowedKeys.includes(key));
};

export const constructUrl = (
    baseUrl: string,
    endpoint: string,
    queryParams?: Record<string, any>
): string => {
    let url = `${baseUrl !== '' ? baseUrl + '/' : ''}${endpoint}`;
    if (queryParams && Object.keys(queryParams).length > 0) {
        const query = new URLSearchParams();
        Object.entries(queryParams).forEach(([key, val]) => {
            query.append(key, String(val));
        });
        url += `?${query.toString()}`;
    }
    return url;
};


export const stringToBoolean = (value: string | undefined | null): boolean => {
    if (!value) {
        return false;
    }
    const val = value.trim().toLowerCase();
    return val === 'true' || val === '1' || val === 'yes' || val === 'on';
};
