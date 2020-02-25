<?php
/**
 * month.php
 *
 * @author Martin Ludvik <matolud@gmail.com>
 * @copyright Copyright &copy; 2014 by Martin Ludvik
 * @license http://opensource.org/licenses/MIT MIT license
 */
?>
<?php $daysresume = LGHelper::functions()->getDaysResume();?>
<thead>
  <tr class="month-year-row">
    <th class="">
      <?php
          
         echo CHtml::link('', $previousUrl, array('class' => 'previous')); ?>
    </th>
    <th class="month-year" colspan="<?php echo $daysInRow - 2; ?>">
      <?php $this->getOwner()->renderFile($titleViewFile, array(
        'pagination' => $pagination,
      )); ?>
    </th>
    <th class="">
      <?php echo CHtml::link('', $nextUrl, array('class' => 'next')); ?>
    </th>
  </tr>
  <tr class="weekdays-row">
    <?php for($i = 0; $i < $daysInRow; ++ $i): ?>
      <th class="<?php echo strtolower($data[$i]->getDate()->format('D')); ?>">
        <?php //echo Yii::t('app', $data[$i]->getDate()->format('D'));
      echo $daysresume[$data[$i]->getDate()->format('D')];
      ?>
      </th>
    <?php endfor ?>
  </tr>
</thead>

<tbody>
  <?php $i = 0; ?>
  <?php while($i < count($data)): ?>
    <tr>
      <?php for($j = 0; $j < $daysInRow; ++ $i, ++ $j): ?>
        <?php
          $classes = array();

          if($data[$i]->isCurrentDate) {
            $classes[] = 'current';
          } else {
            $classes[] = 'not-current';
          }

          if($data[$i]->isRelevantDate) {
            $classes[] = 'relevant';
          } else {
            $classes[] = 'not-relevant';
          }

          $classes[] = strtolower($data[$i]->date->format('D'));

          $classesStr = implode(' ', $classes);
        ?>
        <td class="<?php echo $classesStr; ?>">
          <?php $this->getOwner()->renderFile($itemViewFile, array(
            'data' => $data[$i],
          )); ?>
        </td>
      <?php endfor ?>
    </tr>
  <?php endwhile ?>
</tbody>
