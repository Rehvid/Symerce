export type ApiResponse<T> = {
  data: {
    additionalData?: any,
    [key: string]: any,
  },
  meta: any
}
