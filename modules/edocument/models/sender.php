<?php
/**
 * @filesource modules/edocument/models/sender.php
 * @link http://www.kotchasan.com/
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 */

namespace Edocument\Sender;

/**
 * โมเดลสำหรับขอข้อมูลผู้ส่ง
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Model extends \Kotchasan\Model
{
  private $datas = array();

  /**
   * query รายชื่อผู้ส่ง
   *
   * @param int $id 0 (default) คืนค่าทุกคน, > 0 คืนค่ารายการที่เลือก
   * @return \static
   */
  public static function init($id = 0)
  {
    $model = new static;
    if ($id == 0) {
      $sql1 = $model->db()->createQuery()
        ->select('sender_id')
        ->from('edocument');
    } else {
      $sql1 = array($id);
    }
    $query = $model->db()->createQuery()
      ->select('id', 'name')
      ->from('user U')
      ->where(array('id', 'IN', $sql1))
      ->order('U.name')
      ->toArray();
    foreach ($query->execute() as $item) {
      $model->datas[$item['id']] = $item['name'];
    }
    return $model;
  }

  /**
   * ลิสต์รายชื่อผู้ส่ง
   * สำหรับใส่ลงใน select
   *
   * @return array
   */
  public function toSelect()
  {
    return $this->datas;
  }

  /**
   * อ่านชื่อผู้ส่งที่ $id
   * ไม่พบ คืนค่าว่าง
   *
   * @param int $id
   * @return string
   */
  public function get($id)
  {
    return isset($this->datas[$id]) ? $this->datas[$id] : '';
  }
}
