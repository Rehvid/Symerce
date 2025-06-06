import { UploadFileInterface } from '@admin/common/interfaces/UploadFileInterface';

export interface ProductUploadFileInterface extends UploadFileInterface {
  isThumbnail: boolean,
  position?: number
}
