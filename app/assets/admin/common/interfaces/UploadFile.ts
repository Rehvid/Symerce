export interface UploadFile {
  name: string;
  preview: string;
  content?: string | ArrayBuffer | null;
  size?: number;
  type?: string;
  uuid?: string;
  id?: number;
}
