import { convertFileToBase64 } from '@admin/common/utils/helper';
import { UploadFile } from '@admin/common/interfaces/UploadFile';

export const formatSizeMB = (size: number): string => `${size.toFixed(size)} MB`;

export const isAcceptedType = (file: File, allowedTypes: string[]): boolean => {
    return allowedTypes.includes(file.type);
};
export const isAcceptedSize = (file: File, maxSizeMB: number): boolean => {
    const fileSizeMB = file.size / (1024 * 1024);
    return fileSizeMB <= maxSizeMB;
};

export const convertToUploadFile = async (file: File): Promise<UploadFile> => {
    const base64 = await convertFileToBase64(file);
    return {
        size: file.size,
        type: file.type,
        name: file.name,
        preview: URL.createObjectURL(file),
        content: base64,
        uuid: crypto.randomUUID(),
    };
};
