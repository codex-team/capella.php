# PHP SDK for CodeX Capella 

## Classes

 - [`\Capella\Capella`](#capellacapella)
 - [`\Capella\Uploader`](#capellauploader)
 - [`\Capella\CapellaImage`](#capellacapellaimage)
 - [`\Capella\CapellaException`](#capellacapellaexception)

## `\Capella\Capella`

This class provides two basic methods to work with Capella API.
 
 #### `static upload($path)`
 
 Upload image file to capella.pics, or send image URL.
 
| Parameter | Type | Description |
| --------- | ---- | ----------- |
| `path`    | `string` | Image URL or path to upload to capella.pics |


Return [`CapellaImage`](#capellacapellaimage) object if upload was successful.
Otherwise throws [`CapellaImage`](#capellacapellaexception).  

#### `static image($id)`

Get [`CapellaImage`](#capellacapellaimage) object with passed `$id`

| Parameter | Type     | Description |
| --------- | -------- | ----------- |
| `id`      | `string` | Image id, received from capella.pics |

Return [`CapellaImage`](#capellacapellaimage) object.

## `\Capella\Uploader`

Upload images to capella using cURL.

#### `upload($path)`
| Parameter | Type     | Description |
| --------- | -------- | ----------- |
| `path`    | `string` | Image URL or path to upload to capella.pics |


Return `stdClass` object if path is valid and capella.pics is accessible.

| Field     | Description |
| --------- | ----------- |
| `success` | Upload status |
| `message` | Error or success message |
| `id`      | Uploaded image id |
| `url`     | Uploaded image url |

Throws [`CapellaImage`](#capellacapellaexception) if `path` is not existing file or valid and accessible URL. 

## `\Capella\CapellaImage`

#### Properties

| Property | Description |
| -------- | ----------- |
| `id`     | Image id    |
| `url`    | Base image url |


#### `__constructor($id)`

Set class properties

| Parameter | Type     | Description |
| --------- | -------- | ----------- |
| `id`      | `string` | Image id, received from capella.pics |

#### `resize($width, $height = null)`

Add _resize_ filter to filters sequence

| Parameter | Type     | Description      |
| --------- | -------- | ---------------- |
| `width`   | `int`    | New image width  |
| `height`  | `int`    | _(optional)_ New image height. If not passed, image will be resized to fit passed width |

Return `CapellaImage` object with added filter

#### `crop($width, $height = null, $left = null, $top = null)`

Add _crop_ filter to filters sequence

| Parameter | Type     | Description      |
| --------- | -------- | ---------------- |
| `width`   | `int`    | Crop width       |
| `height`  | `int`    | _(optional)_ Crop height. If not passed, image will be resized to fit passed width |
| `left`    | `int`    | _(optional)_ X coordinate of top left corner of crop area. If not passed, image will be centred before crop |
| `top`     | `int`    | _(optional)_ Y coordinate of top left corner of crop area. If not passed, image will be centred before crop |

Return `CapellaImage` object with added filter

#### `pixelize($size)`

Add _pixelize_ filter to filters sequence

| Parameter | Type     | Description |
| --------- | -------- | ----------- |
| `size`    | `int`    | Pixels number on the longest side|

Return `CapellaImage` object with added filter

#### `clear()`

Clear filters sequence.

Return `CapellaImage` object with cleared filters

#### `url()`

Return url to image with applied filters.

Return `string`


## `\Capella\CapellaException`

Extends the `\Exception` class
