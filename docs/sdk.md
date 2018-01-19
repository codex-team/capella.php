# PHP SDK for CodeX Capella 

## Classes

 - [`\Capella\Capella`](#capellacapella)
 - [`\Capella\Uploader`](#capellauploader)
 - [`\Capella\CapellaImage`](#capellacapellaimage)
 - [`\Capella\CapellaException`](#capellacapellaexception)

## `\Capella\Capella`

This class provides two basic methods for working with [Capella API](https://github.com/codex-team/capella#readme).
 
 #### `static upload($path)`
 
 Upload an `Image file` or send an `Image URL` to the Capella.
 
| Parameter | Type | Description |
| --------- | ---- | ----------- |
| `path`    | `string` | Image URL of File path that should be uploaded to the Capella |


Return [`CapellaImage`](#capellacapellaimage) object if upload was successful.
Otherwise throws the [`CapellaImage`](#capellacapellaexception).  

#### `static image($id)`

Get [`CapellaImage`](#capellacapellaimage) object with passed `$id`

| Parameter | Type     | Description |
| --------- | -------- | ----------- |
| `id`      | `string` | Image id received from the Capella |

Return the [`CapellaImage`](#capellacapellaimage) object.

## `\Capella\Uploader`

Upload images to the Capella using cURL.

#### `upload($path)`
| Parameter | Type     | Description |
| --------- | -------- | ----------- |
| `path`    | `string` | Image URL of File path that should be uploaded to the Capella |


Return `stdClass` object if path is valid and Capella is accessible.

| Field     | Description |
| --------- | ----------- |
| `success` | Upload status |
| `message` | Error or success message |
| `id`      | Uploaded image id |
| `url`     | Uploaded image URL |

Throws the [`CapellaException`](#capellacapellaexception) 
if passed `path` either invalid file link or inaccessible URL 

## `\Capella\CapellaImage`

This class provides methods for applying filters.

#### Properties

| Property | Description |
| -------- | ----------- |
| `id`     | Image id    |
| `url`    | Base image URL |


#### `__constructor($id)`

Set class properties

| Parameter | Type     | Description |
| --------- | -------- | ----------- |
| `id`      | `string` | Image id received from the Capella |

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

Return URL to the image with applied filters.

Return `string`


## `\Capella\CapellaException`

Extends the `\Exception` class
