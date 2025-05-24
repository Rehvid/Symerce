import { UploadFileInterface } from '@admin/shared/interfaces/UploadFileInterface';

export interface ProductUploadFileInterface extends UploadFileInterface {
  isThumbnail: boolean,
  position?: number
}
