import { UploadFile } from '@admin/common/interfaces/UploadFile';

export interface ProductUploadFileInterface extends UploadFile {
  isThumbnail: boolean,
  position?: number
}
